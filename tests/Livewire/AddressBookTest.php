<?php

declare(strict_types=1);

namespace Igniter\Orange\Tests\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Http\Controllers\Themes;
use Igniter\Main\Models\Theme;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Orange\Livewire\AddressBook;
use Igniter\System\Models\Country;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Livewire\Livewire;
use Livewire\WithPagination;

beforeEach(function(): void {
    $this->address = Address::factory()->create();
    $this->customer = Customer::factory()
        ->for($this->address)
        ->create([
            'first_name' => 'Test',
            'last_name' => 'User',
        ]);

    $this->address->customer_id = $this->customer->getKey();
    $this->address->save();
});

it('initialize component correctly', function(): void {
    $component = new AddressBook;

    expect(class_uses_recursive($component))
        ->toContain(ConfigurableComponent::class, WithPagination::class)
        ->and($component->addressId)->toBeNull()
        ->and($component->defaultAddressId)->toBeNull()
        ->and($component->showModal)->toBeFalse()
        ->and($component->itemsPerPage)->toBe(20)
        ->and($component->sortOrder)->toBe('created_at desc');
});

it('returns correct component meta', function(): void {
    $meta = AddressBook::componentMeta();

    expect($meta['code'])->toBe('igniter-orange::address-book')
        ->and($meta['name'])->toBe('igniter.orange::default.component_address_book_title')
        ->and($meta['description'])->toBe('igniter.orange::default.component_address_book_desc');
});

it('defines properties correctly', function(): void {
    $component = new AddressBook;
    $properties = $component->defineProperties();

    expect($properties)->toEqual([
        'itemsPerPage' => [
            'label' => 'Number of addresses to display per page',
            'type' => 'number',
        ],
        'sortOrder' => [
            'label' => 'Default sort order of addresses',
            'type' => 'select',
        ],
    ]);
});

it('mounts correctly', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->assertSet('defaultAddressId', $this->address->getKey())
        ->assertSet('form.country_id', Country::getDefaultKey());
});

it('loads empty address book when customer is not authenticated', function(): void {
    Livewire::test(AddressBook::class)
        ->assertSet('defaultAddressId', null)
        ->assertViewHas('addresses', []);
});

it('updates address id correctly', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->assertSet('addressId', null)
        ->assertSet('showModal', false)
        ->set('addressId', 1)
        ->assertSet('showModal', true);
});

it('creates address correctly', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->set('form.address_1', '123 Test St')
        ->set('form.city', 'Test city')
        ->set('form.country_id', 123)
        ->set('form.postcode', 'postcode')
        ->call('onSave')
        ->assertSet('addressId', null)
        ->assertSet('showModal', false);

    $this->assertDatabaseHas('addresses', [
        'address_1' => '123 Test St',
        'city' => 'Test city',
        'country_id' => 123,
        'postcode' => 'postcode',
    ]);
});

it('updates existing address correctly', function(): void {
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->set('addressId', $this->address->getKey())
        ->set('form.address_1', '123 Test St')
        ->set('form.city', 'Test city')
        ->set('form.country_id', 123)
        ->set('form.postcode', 'postcode')
        ->call('onSave')
        ->assertSet('addressId', null)
        ->assertSet('showModal', false);
});

it('sets default address correctly', function(): void {
    $address = Address::factory()->for($this->customer)->create();
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->call('onSetDefault', $address->getKey())
        ->assertSet('defaultAddressId', $address->getKey());
});

it('deletes address correctly', function(): void {
    $address = Address::factory()->for($this->customer)->create();
    Livewire::actingAs($this->customer, 'igniter-customer')
        ->test(AddressBook::class)
        ->call('onDelete', $address->getKey())
        ->assertSet('addressId', null);
});

it('returns correct sorted order options', function(): void {
    $form = new Form(resolve(Themes::class), [
        'model' => new Theme,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'sortOrder',
    ]);

    $options = AddressBook::getPropertyOptions($form, $field);

    expect($options)->toBeArray()->not->toBeEmpty();
});

it('returns empty array for unknown property', function(): void {
    $form = new Form(resolve(Menus::class), [
        'model' => new Address,
    ]);
    $field = new FormField('sortOrder', 'Sort Order');
    $field->displayAs('select', [
        'property' => 'unknownProperty',
    ]);

    $options = AddressBook::getPropertyOptions($form, $field);

    expect($options)->toBe([]);
});

it('loads component form on theme editor', function(): void {
    $theme = resolve(ThemeManager::class)->findTheme('igniter-orange');
    $theme->locked = false;

    session()->put('widget.Themes-templateeditor-formtemplate-template', [
        'igniter-orange-selected-type' => '_pages',
        'igniter-orange-selected-file' => 'account.address',
        'igniter-orange-selected-mTime' => 1716194991,
    ]);

    actingAsSuperUser()
        ->post(route('igniter.main.themes', ['slug' => 'source/igniter-orange']), [
            'context' => 'edit',
            'alias' => 'igniter-orange::address-book',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formSettingsComponents::onLoadRecord',
        ])
        ->assertSee('Number of addresses to display per page')
        ->assertSee('Default sort order of addresses');
});
