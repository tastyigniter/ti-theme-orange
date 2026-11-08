<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Models\Status;
use Igniter\Cart\CartItemOption;
use Igniter\Cart\CartItemOptions;
use Igniter\Cart\CartItemOptionValue;
use Igniter\Cart\CartItemOptionValues;
use Igniter\Cart\Classes\CartManager;
use Igniter\Cart\Classes\OrderManager;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Cart\Models\Order;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\OrderPreview;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use ReflectionMethod;

beforeEach(function(): void {
    $status = Status::factory()->create();
    $this->order = Order::factory()->create(['processed' => 1]);
    $this->order->updateOrderStatus($status->getKey());
});

it('initialize component correctly', function(): void {
    $component = new OrderPreview;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, UsesPage::class)
        ->and($component->hashParamName)->toBe('hash')
        ->and($component->hash)->toBeNull()
        ->and($component->loginPage)->toBe('account.login')
        ->and($component->ordersPage)->toBe('account.orders')
        ->and($component->checkoutPage)->toBe('checkout.checkout')
        ->and($component->menusPage)->toBe('local.menus')
        ->and($component->loginUrl)->toBe('')
        ->and($component->hideReorderBtn)->toBeTrue()
        ->and($component->showCancelButton)->toBeFalse();
});

it('returns correct component meta', function(): void {
    $meta = OrderPreview::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::order-preview')
        ->and($meta['name'])->toBe('igniter.orange::default.component_order_preview_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_order_preview_desc');
});

it('defines properties correctly', function(): void {
    $component = new OrderPreview;
    $properties = $component->defineProperties();

    expect(array_keys($properties))->toContain(
        'hashParamName',
        'loginPage',
        'ordersPage',
        'checkoutPage',
        'menusPage',
        'hideReorderBtn',
    );
});

it('mounts and prepare props', function(): void {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->assertSet('hashParamName', 'hash')
        ->assertSet('loginPage', 'account.login')
        ->assertSet('ordersPage', 'account.orders')
        ->assertSet('checkoutPage', 'checkout.checkout')
        ->assertSet('menusPage', 'local.menus')
        ->assertSet('hideReorderBtn', true)
        ->assertSet('showCancelButton', false);
});

it('redirects when mounting with unprocessed order', function(): void {
    $order = Order::factory()->create();

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->assertSet('order', null);
});

it('clears completed order from session', function(): void {
    resolve(OrderManager::class)->setCurrentOrderId($this->order->order_id);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash]);

    expect(resolve(OrderManager::class)->getCurrentOrderId())->toBeNull();
});

it('gets status width for progress bars for no matching status', function(): void {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => '0',
            'processing' => '0',
            'completed' => '0',
        ]);
});

it('gets status width for progress bars for default status', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create(['processed' => 1]);
    $order->updateOrderStatus($status->getKey());

    setting()->set('default_order_status', $status->getKey());

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => 50,
            'processing' => '0',
            'completed' => '0',
        ]);
});

it('gets status width for progress bars for processing status', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create(['processed' => 1]);
    $order->updateOrderStatus($status->getKey());

    setting()->set('processing_order_status', [$status->getKey()]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => 100,
            'processing' => 50,
            'completed' => '0',
        ]);
});

it('gets status width for progress bars for completed status', function(): void {
    $status = Status::factory()->create();
    $order = Order::factory()->create(['processed' => 1]);
    $order->updateOrderStatus($status->getKey());

    setting()->set('completed_order_status', [$status->getKey()]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('getStatusWidthForProgressBars')
        ->assertReturned([
            'default' => 100,
            'processing' => 100,
            'completed' => 100,
        ]);
});

it('shows cancel button', function(): void {
    $this->travelTo('2021-01-01 12:00:00');
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'order_date' => now()->toDateString(),
        'order_time' => now()->addHour()->toTimeString(),
        'processed' => 1,
    ]);
    $order->updateOrderStatus($status->getKey());

    $order->location->settings()->create([
        'item' => $order->order_type,
        'data' => ['cancellation_timeout' => 15],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('showCancelButton')
        ->assertReturned(true);
});

it('errors when reordering with an invalid menu item', function(): void {
    $this->order->menus()->create([
        'menu_id' => 123,
        'name' => 'Menu Name',
        'quantity' => 5,
        'price' => 20,
        'subtotal' => 100,
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('handles reorder', function(): void {
    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertRedirect();
});

it('uses the original order location when validating a reorder', function(): void {
    $currentLocation = LocationModel::factory()->create();
    resolve('location')->setCurrent($currentLocation);

    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(resolve('location')->getId())->toBe($currentLocation->getKey());
});

it('matches a historical option value by name when its id changed', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create([
        'option_name' => 'Basis',
        'display_type' => 'radio',
    ]);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);

    $oldOptionValue = MenuOptionValue::factory()->create([
        'option_id' => $option->getKey(),
        'name' => 'Rijst',
        'price' => 0,
    ]);
    $oldMenuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $oldOptionValue->getKey(),
    ]);

    $this->order->addOrderMenus([
        (object)[
            'id' => $menu->getKey(),
            'name' => $menu->menu_name,
            'qty' => 1,
            'price' => $menu->menu_price,
            'subtotal' => $menu->menu_price,
            'comment' => '',
            'options' => CartItemOptions::make([
                CartItemOption::fromArray([
                    'id' => $menuOption->getKey(),
                    'name' => 'Basis',
                    'values' => CartItemOptionValues::make([
                        CartItemOptionValue::fromArray([
                            'id' => $oldMenuOptionValue->getKey(),
                            'name' => 'Rijst',
                            'price' => 0,
                            'qty' => 1,
                        ]),
                    ]),
                ]),
            ]),
        ],
    ]);

    $oldMenuOptionValue->delete();

    $newOptionValue = MenuOptionValue::factory()->create([
        'option_id' => $option->getKey(),
        'name' => 'Rijst',
        'price' => 0,
    ]);
    $newMenuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $newOptionValue->getKey(),
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasNoErrors()
        ->assertRedirect();

    $cartManager = resolve(CartManager::class);
    $cartManager->cartInstance($this->order->location_id);
    $restoredValue = $cartManager->getCart()->content()->first()->options->first()->values->first();

    expect($restoredValue->id)->toBe($newMenuOptionValue->getKey());
});

it('does not change the cart when a historical selected option is unavailable', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create();
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $menuOption->getKey(),
        'menu_option_value_id' => $menuOptionValue->getKey(),
        'order_option_name' => $menuOptionValue->name,
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $menuOptionValue->delete();

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);

    $cartManager = resolve(CartManager::class);
    $cartManager->cartInstance($this->order->location_id);

    expect($cartManager->getCart()->content())->toHaveCount(0);
});

it('handles cancel order', function(): void {
    $this->travelTo('2021-01-01 12:00:00');
    $status = Status::factory()->create();
    $order = Order::factory()->create([
        'order_date' => now()->toDateString(),
        'order_time' => now()->addHour()->toTimeString(),
        'processed' => 1,
    ]);
    $order->updateOrderStatus($status->getKey());

    $order->location->settings()->create([
        'item' => $order->order_type,
        'data' => ['cancellation_timeout' => 15],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $order->hash])
        ->call('onCancel')
        ->assertHasNoErrors();
});

it('errors when reordering with a menu item no longer available at the order location', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach(LocationModel::factory()->create());

    $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('errors when reordering with a deleted menu option without a historical name', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create();
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $menuOption->getKey(),
        'menu_option_value_id' => $menuOptionValue->getKey(),
        'order_option_name' => 'Soy sauce',
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $menuOption->delete();

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);

    $cartManager = resolve(CartManager::class);
    $cartManager->cartInstance($this->order->location_id);

    expect($cartManager->getCart()->content())->toHaveCount(0);
});

it('matches a historical option group by name when its id changed', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $oldOption = MenuOption::factory()->create(['option_name' => 'Basis', 'display_type' => 'checkbox']);
    $oldMenuOption = $menu->menu_options()->create(['option_id' => $oldOption->getKey()]);
    $oldOptionValue = MenuOptionValue::factory()->create([
        'option_id' => $oldOption->getKey(),
        'name' => 'Rijst',
        'price' => 0,
    ]);
    $oldMenuOptionValue = $oldMenuOption->menu_option_values()->create([
        'option_value_id' => $oldOptionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [
            $oldMenuOption->getKey() => ['name' => 'Basis', 'values' => []],
        ],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $oldMenuOption->getKey(),
        'menu_option_value_id' => $oldMenuOptionValue->getKey(),
        'order_option_name' => 'Rijst',
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $newOption = MenuOption::factory()->create(['option_name' => 'Basis', 'display_type' => 'checkbox']);
    $newMenuOption = $menu->menu_options()->create(['option_id' => $newOption->getKey()]);
    $newOptionValue = MenuOptionValue::factory()->create([
        'option_id' => $newOption->getKey(),
        'name' => 'Rijst',
        'price' => 0,
    ]);
    $newMenuOptionValue = $newMenuOption->menu_option_values()->create([
        'option_value_id' => $newOptionValue->getKey(),
    ]);

    $oldMenuOption->delete();

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasNoErrors()
        ->assertRedirect();

    $cartManager = resolve(CartManager::class);
    $cartManager->cartInstance($this->order->location_id);
    $restoredValue = $cartManager->getCart()->content()->first()->options->first()->values->first();

    expect($restoredValue->id)->toBe($newMenuOptionValue->getKey());
});

it('errors when reordering with a newly required menu option', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'select']);
    $menu->menu_options()->create([
        'option_id' => $option->getKey(),
        'is_required' => true,
    ]);

    $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('restores an intact historical option value by id when reordering', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create(['name' => 'Soy sauce', 'price' => 0]);
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $this->order->addOrderMenus([
        (object)[
            'id' => $menu->getKey(),
            'name' => $menu->menu_name,
            'qty' => 1,
            'price' => $menu->menu_price,
            'subtotal' => $menu->menu_price,
            'comment' => '',
            'options' => CartItemOptions::make([
                CartItemOption::fromArray([
                    'id' => $menuOption->getKey(),
                    'name' => 'Sauce',
                    'values' => CartItemOptionValues::make([
                        CartItemOptionValue::fromArray([
                            'id' => $menuOptionValue->getKey(),
                            'name' => 'Soy sauce',
                            'price' => 0,
                            'qty' => 1,
                        ]),
                    ]),
                ]),
            ]),
        ],
    ]);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasNoErrors()
        ->assertRedirect();

    $cartManager = resolve(CartManager::class);
    $cartManager->cartInstance($this->order->location_id);
    $restoredValue = $cartManager->getCart()->content()->first()->options->first()->values->first();

    expect($restoredValue->id)->toBe($menuOptionValue->getKey());
});

it('errors when reordering with a deleted option value and no saved option name', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create();
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $menuOption->getKey(),
        'menu_option_value_id' => $menuOptionValue->getKey(),
        'order_option_name' => '',
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $menuOptionValue->delete();

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('errors with the historical option name when reordering a deleted menu option', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create();
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [
            $menuOption->getKey() => ['name' => 'Old sauce choice', 'values' => []],
        ],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $menuOption->getKey(),
        'menu_option_value_id' => $menuOptionValue->getKey(),
        'order_option_name' => 'Soy sauce',
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $menuOption->delete();

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('redirects when mounting without an order hash', function(): void {
    Livewire::test(OrderPreview::class)
        ->assertRedirect();
});

it('errors when restoring order menus returns notes', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    $cartManager = new class extends CartManager
    {
        public function restoreWithOrderMenus(Collection $orderMenuItems)
        {
            return ['Some items are no longer available'];
        }
    };
    app()->instance(CartManager::class, $cartManager);

    Livewire::test(OrderPreview::class, ['hash' => $this->order->hash])
        ->call('onReOrder')
        ->assertHasErrors(['onReOrder']);
});

it('skips unresolvable menu options when normalizing historical order options', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create();
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $menuOption->getKey(),
        'menu_option_value_id' => $menuOptionValue->getKey(),
        'order_option_name' => 'Soy sauce',
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $menuOption->delete();

    $order = $this->order->fresh();
    $method = new ReflectionMethod(OrderPreview::class, 'normalizeHistoricalOrderOptions');
    $method->invoke(new OrderPreview, $order);

    expect($order->menus->first()->option_values)->toBe([]);
});

it('skips unresolvable option values when normalizing historical order options', function(): void {
    $menu = Menu::factory()->create();
    $menu->locations()->attach($this->order->location);

    $option = MenuOption::factory()->create(['option_name' => 'Sauce', 'display_type' => 'checkbox']);
    $menuOption = $menu->menu_options()->create(['option_id' => $option->getKey()]);
    $optionValue = MenuOptionValue::factory()->create();
    $menuOptionValue = $menuOption->menu_option_values()->create([
        'option_value_id' => $optionValue->getKey(),
    ]);

    $orderMenu = $this->order->menus()->create([
        'menu_id' => $menu->getKey(),
        'name' => $menu->menu_name,
        'quantity' => 1,
        'price' => $menu->menu_price,
        'subtotal' => $menu->menu_price,
        'option_values' => [],
    ]);

    $orderMenu->menu_options()->create([
        'order_id' => $this->order->getKey(),
        'menu_option_id' => $menuOption->getKey(),
        'menu_option_value_id' => $menuOptionValue->getKey(),
        'order_option_name' => 'Deleted value',
        'order_option_price' => 0,
        'quantity' => 1,
        'free_qty' => 0,
    ]);

    $menuOptionValue->delete();

    $order = $this->order->fresh();
    $method = new ReflectionMethod(OrderPreview::class, 'normalizeHistoricalOrderOptions');
    $method->invoke(new OrderPreview, $order);

    $optionValues = $order->menus->first()->option_values;

    expect($optionValues)->toHaveCount(1)
        ->and($optionValues[0]['id'])->toBe($menuOption->getKey())
        ->and($optionValues[0]['values'])->toBeEmpty();
});
