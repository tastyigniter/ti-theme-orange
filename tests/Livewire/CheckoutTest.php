<?php

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Facades\Cart;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\LocationArea;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Checkout;
use Igniter\PayRegister\Concerns\WithPaymentProfile;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Models\PaymentProfile;
use Igniter\PayRegister\Payments\Cod;
use Igniter\System\Facades\Assets;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

function setupCheckout()
{
    $location = Location::factory()->create();
    $menuItem = Menu::factory()->create();
    $cartItem = Cart::add([
        'id' => $menuItem->getKey(),
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);
    LocationFacade::setModel($location);

    // Set user delivery address
    LocationFacade::updateUserPosition(GeoliteLocation::createFromArray([
        'latitude' => 51.50987615,
        'longitude' => -0.1446716,
        'streetNumber' => '123',
        'streetName' => 'Main Street',
        'subLocality' => 'Suburb',
        'locality' => 'City',
        'postalCode' => '12345',
    ]));

    return (object)[
        'location' => $location,
        'cartItem' => $cartItem,
    ];
}

it('initialize component correctly', function() {
    $component = new Checkout();

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, EventEmitter::class, UsesPage::class)
        ->and($component->isTwoPageCheckout)->toBeFalse()
        ->and($component->hideTelephoneField)->toBeFalse()
        ->and($component->hideCommentField)->toBeFalse()
        ->and($component->hideDeliveryCommentField)->toBeFalse()
        ->and($component->telephoneIsRequired)->toBeTrue()
        ->and($component->agreeTermsSlug)->toBe('terms-and-conditions')
        ->and($component->menusPage)->toBe('local.menus')
        ->and($component->checkoutPage)->toBe('checkout.checkout')
        ->and($component->successPage)->toBe('checkout.success')
        ->and($component->checkoutStep)->toBe('details');
});

it('returns correct component meta', function() {
    $meta = Checkout::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::checkout')
        ->and($meta['name'])->toBe('igniter.orange::default.component_checkout_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_checkout_desc');
});

it('defines properties correctly', function() {
    $component = new Checkout();
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'isTwoPageCheckout',
        'hideTelephoneField',
        'hideCommentField',
        'hideDeliveryCommentField',
        'telephoneIsRequired',
        'agreeTermsSlug',
        'menusPage',
        'checkoutPage',
        'successPage',
    );
});

it('can mount and prepare props', function() {
    Event::fake(['igniter.orange.checkCheckoutSecurity']);
    $location = Location::factory()->create();
    $menuItem = Menu::factory()->create();
    LocationFacade::setModel($location);

    // Add a cart item
    Cart::add([
        'id' => $menuItem->getKey(),
        'name' => 'Test Item',
        'price' => 10.00,
    ], 1);

    Assets::shouldReceive('addJs')->once()->with('igniter-orange::/js/checkout.js', 'checkout-js');
    // Set user delivery address
    $userPosition = GeoliteLocation::createFromArray([
        'latitude' => 51.50987615,
        'longitude' => -0.1446716,
        'streetNumber' => '123',
        'streetName' => 'Main Street',
        'subLocality' => 'Suburb',
        'locality' => 'City',
        'postalCode' => '12345',
    ]);
    LocationFacade::updateUserPosition($userPosition);

    Livewire::test(Checkout::class)
        ->assertSet('fields', function($fields) {
            return [
                    'first_name', 'last_name', 'email', 'telephone',
                    'comment', 'delivery_comment', 'payment', 'termsAgreed',
                    'address_1', 'city', 'state', 'postcode',
                ] === array_keys($fields);
        });

    Event::assertDispatched('igniter.orange.checkCheckoutSecurity');
});

it('mount redirects when order is already processed', function() {
    Event::fake([
        'igniter.orange.checkCheckoutSecurity',
        'admin.order.paymentProcessed',
        'admin.statusHistory.added',
    ]);
    setupCheckout();
    $order = resolve(OrderManager::class)->getOrder();
    $order->markAsPaymentProcessed();
    $order->updateOrderStatus(1);

    Livewire::test(Checkout::class)
        ->assertRedirect(page_url('checkout.success', ['hash' => $order->hash]));
});

it('mount redirects when checkout security checks fails', function() {
    Event::fake(['igniter.orange.checkCheckoutSecurity']);
    $result = setupCheckout();

    $area = LocationArea::factory()->create([
        'conditions' => [
            ['type' => 'above', 'amount' => -1, 'total' => 0, 'priority' => 1],
        ],
    ]);
    $result->location->delivery_areas()->save($area);
    LocationFacade::updateNearbyArea($area);

    $component = Livewire::test(Checkout::class)
        ->assertRedirect(restaurant_url('local.menus'));

    expect(flash()->messages()->first())->toBeNull();
});

it('onValidate fails validation when checkout security checks fails', function() {
    Event::fake(['igniter.orange.checkCheckoutSecurity']);
    $result = setupCheckout();

    $component = Livewire::test(Checkout::class);

    $result->location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['min_order_amount' => 60],
    ]);
    $result->location->reloadRelations('settings');

    $component->dispatch('checkout::validate')
        ->assertRedirect(restaurant_url('local.menus'));

    expect(flash()->messages()->first())->message->toBe(sprintf(lang('igniter.cart::default.alert_min_order_total'),
        currency_format(60.00)));
});

it('onValidate redirects to success page when order is already processed', function() {
    Event::fake([
        'igniter.orange.checkCheckoutSecurity',
        'admin.order.paymentProcessed',
        'admin.statusHistory.added',
    ]);
    setupCheckout();
    $component = Livewire::test(Checkout::class);

    $order = resolve(OrderManager::class)->getOrder();
    $order->markAsPaymentProcessed();
    $order->updateOrderStatus(1);

    $component->dispatch('checkout::validate')
        ->assertRedirect(page_url('checkout.success', ['hash' => $order->hash]));
});

it('onValidate fails validation when selected payment is invalid', function() {
    setupCheckout();
    $order = Order::factory()->create([
        'order_type' => Location::COLLECTION,
        'payment' => 'invalid',
    ]);
    $orderManager = resolve(OrderManager::class);
    $orderManager->setCurrentOrderId($order->order_id);
    $orderManager->setCurrentPaymentCode('invalid');
    LocationFacade::updateOrderType($order->order_type);

    Livewire::test(Checkout::class)
        ->dispatch('checkout::validate')
        ->assertHasErrors(['payment' => [lang('igniter.cart::default.checkout.error_invalid_payment')]]);
});

it('onValidate fails validation when delivery address is invalid', function() {
    setupCheckout();

    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => 51.50987615,
            'longitude' => -0.1446716,
            'subLocality' => 'Suburb',
            'locality' => 'City',
            'postalCode' => '12345',
        ]),
    ]));

    Livewire::test(Checkout::class)
        ->dispatch('checkout::validate')
        ->assertHasErrors(['delivery_address' => [lang('igniter.local::default.alert_missing_street_address')]]);
});

it('onValidate dispatches an event on success', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $order = Order::factory()->create([
        'order_type' => Location::COLLECTION,
    ]);
    $orderManager = resolve(OrderManager::class);
    $orderManager->setCurrentOrderId($order->order_id);
    LocationFacade::updateOrderType($order->order_type);

    Livewire::test(Checkout::class)
        ->set('agreeTermsSlug', '')
        ->set('hideTelephoneField', true)
        ->set('hideCommentField', true)
        ->set('hideDeliveryCommentField', true)
        ->set('fields.first_name', 'John')
        ->set('fields.last_name', 'Doe')
        ->set('fields.email', 'test@example.com')
        ->dispatch('checkout::validate')
        ->assertDispatched('checkout::validated');

    Event::assertDispatched('igniter.orange.validateCheckout');
});

it('onConfirm fails validation when checkout security fails', function() {
    Event::fake(['igniter.orange.checkCheckoutSecurity']);
    $result = setupCheckout();

    $component = Livewire::test(Checkout::class);

    $area = LocationArea::factory()->create([
        'conditions' => [
            ['type' => 'above', 'amount' => -1, 'total' => 0, 'priority' => 1],
        ],
    ]);
    $result->location->delivery_areas()->save($area);
    LocationFacade::updateNearbyArea($area);

    $component->dispatch('checkout::confirm')
        ->assertRedirect(restaurant_url('local.menus'));

    expect(flash()->messages()->first())->toBeNull();
});

it('onConfirm redirects to success page when order is already processed', function() {
    Event::fake([
        'igniter.orange.checkCheckoutSecurity',
        'admin.order.paymentProcessed',
        'admin.statusHistory.added',
    ]);
    setupCheckout();
    $component = Livewire::test(Checkout::class);

    $order = resolve(OrderManager::class)->getOrder();
    $order->markAsPaymentProcessed();
    $order->updateOrderStatus(1);

    $component->dispatch('checkout::confirm')
        ->assertRedirect(page_url('checkout.success', ['hash' => $order->hash]));
});

it('onConfirm redirects to payment when in two page checkout mode', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $order = Order::factory()->create([
        'order_type' => Location::COLLECTION,
    ]);
    $orderManager = resolve(OrderManager::class);
    $orderManager->setCurrentOrderId($order->order_id);
    LocationFacade::updateOrderType($order->order_type);

    Livewire::test(Checkout::class)
        ->set('isTwoPageCheckout', true)
        ->set('checkoutStep', 'details')
        ->set('agreeTermsSlug', '')
        ->set('hideTelephoneField', true)
        ->set('hideCommentField', true)
        ->set('hideDeliveryCommentField', true)
        ->set('fields.first_name', 'John')
        ->set('fields.last_name', 'Doe')
        ->set('fields.email', 'test@example.com')
        ->dispatch('checkout::confirm')
        ->assertRedirectContains('?step=pay');

    Event::assertDispatched('igniter.orange.validateCheckout');
});

it('onConfirm errors when order total is below payment minimum order total', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $order = Order::factory()->create([
        'order_type' => Location::COLLECTION,
    ]);
    $orderManager = resolve(OrderManager::class);
    $orderManager->setCurrentOrderId($order->order_id);
    LocationFacade::updateOrderType($order->order_type);
    $payment = Payment::firstWhere('code', 'cod');
    $payment->order_total = 100;
    $payment->save();

    Livewire::test(Checkout::class)
        ->set('agreeTermsSlug', '')
        ->set('hideTelephoneField', true)
        ->set('hideCommentField', true)
        ->set('hideDeliveryCommentField', true)
        ->set('fields.first_name', 'John')
        ->set('fields.last_name', 'Doe')
        ->set('fields.email', 'test@example.com')
        ->dispatch('checkout::confirm')
        ->assertHasErrors(['fields.payment' => [sprintf(
            lang('igniter.payregister::default.alert_min_order_total'),
            currency_format(100.00),
            'Cash On Delivery',
        )]]);
});

it('onConfirm does not redirect when payment gateway returns false', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $order = Order::factory()->create([
        'order_type' => Location::COLLECTION,
    ]);
    $orderManager = resolve(OrderManager::class);
    $orderManager->setCurrentOrderId($order->order_id);
    LocationFacade::updateOrderType($order->order_type);
    $payment = Payment::firstWhere('code', 'cod');
    $payment->class_name = TestPaymentWithFalse::class;
    $payment->save();

    Livewire::test(Checkout::class)
        ->set('agreeTermsSlug', '')
        ->set('hideTelephoneField', true)
        ->set('hideCommentField', true)
        ->set('hideDeliveryCommentField', true)
        ->set('fields.first_name', 'John')
        ->set('fields.last_name', 'Doe')
        ->set('fields.email', 'test@example.com')
        ->dispatch('checkout::confirm')
        ->assertNoRedirect();
});

it('onConfirm redirects when payment gateway redirects', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $order = Order::factory()->create([
        'order_type' => Location::COLLECTION,
    ]);
    $orderManager = resolve(OrderManager::class);
    $orderManager->setCurrentOrderId($order->order_id);
    LocationFacade::updateOrderType($order->order_type);
    $payment = Payment::firstWhere('code', 'cod');
    $payment->class_name = TestPaymentReturnsRedirect::class;
    $payment->save();

    Livewire::test(Checkout::class)
        ->set('agreeTermsSlug', '')
        ->set('hideTelephoneField', true)
        ->set('hideCommentField', true)
        ->set('hideDeliveryCommentField', true)
        ->set('fields.first_name', 'John')
        ->set('fields.last_name', 'Doe')
        ->set('fields.email', 'test@example.com')
        ->set('fields.payment', 'cod')
        ->dispatch('checkout::confirm')
        ->assertRedirect('http://example.com');
});

it('onConfirm redirects to success page correctly', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $orderManager = resolve(OrderManager::class);
    $order = $orderManager->getOrder();
    $order->order_type = Location::COLLECTION;
    $order->save();
    LocationFacade::updateOrderType(Location::COLLECTION);

    Livewire::test(Checkout::class)
        ->set('agreeTermsSlug', '')
        ->set('hideTelephoneField', true)
        ->set('hideCommentField', true)
        ->set('hideDeliveryCommentField', true)
        ->set('fields.first_name', 'John')
        ->set('fields.last_name', 'Doe')
        ->set('fields.email', 'test@example.com')
        ->set('fields.payment', 'cod')
        ->dispatch('checkout::confirm')
        ->assertRedirect(page_url('checkout.success', ['hash' => $order->hash]));
});

it('updates selected payment correctly', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();

    Livewire::test(Checkout::class)
        ->set('fields.payment', '')
        ->dispatch('checkout::choose-payment', code: 'cod')
        ->assertSet('fields.payment', 'cod');
});

it('deletes customer payment profile correctly', function() {
    Event::fake(['igniter.orange.validateCheckout']);
    setupCheckout();
    $customer = Customer::factory()->create();
    $payment = Payment::firstWhere('code', 'cod');
    $payment->class_name = TestPaymentWithProfile::class;
    $payment->save();
    PaymentProfile::create([
        'customer_id' => $customer->getKey(),
        'payment_id' => $payment->getKey(),
    ]);

    Livewire::actingAs($customer, 'igniter-customer')
        ->test(Checkout::class)
        ->dispatch('checkout::delete-payment-profile', code: 'cod');

    expect(PaymentProfile::where('customer_id', $customer->getKey())->count())->toBe(0);
});

class TestPaymentWithFalse extends Cod
{
    public function processPaymentForm($data, $host, $order)
    {
        return false;
    }
}

class TestPaymentReturnsRedirect extends Cod
{
    public function processPaymentForm($data, $host, $order)
    {
        return redirect('http://example.com');
    }
}

class TestPaymentWithProfile extends Cod
{
    use WithPaymentProfile;

    public function paymentProfileExists(): bool
    {
        return true;
    }

    public function deletePaymentProfile() {}
}
