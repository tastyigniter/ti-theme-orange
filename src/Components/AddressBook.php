<?php

namespace Igniter\Orange\Components;

use Igniter\Admin\Traits\ValidatesForm;
use Igniter\User\Facades\Auth;
use Igniter\User\Models\Address;
use Illuminate\Support\Facades\Redirect;

class AddressBook extends \Igniter\System\Classes\BaseComponent
{
    use ValidatesForm;

    public function onRun()
    {
        if ($this->param('setDefault') == '1') {
            return $this->setDefaultAddress();
        }

        $this->page['addAddressEventHandler'] = $this->getEventHandler('onLoadAddForm');
        $this->page['submitAddressEventHandler'] = $this->getEventHandler('onSubmit');

        $this->page['customer'] = Auth::customer();
        $this->page['customerAddresses'] = $this->loadAddressBook();

        $this->page['addressIdParam'] = $this->param('addressId');
        $this->page['address'] = $this->getAddress();
    }

    public function onLoadAddForm()
    {
        $this->pageCycle();

        $this->page['address'] = Address::make();

        return ['#address-book' => $this->renderPartial('@form')];
    }

    public function onSubmit()
    {
        $data = post();

        $rules = [
            ['address.address_1', 'lang:igniter.user::default.account.label_address_1', 'required|min:3|max:128'],
            ['address.address_2', 'lang:igniter.user::default.account.label_address_2', 'max:128'],
            ['address.city', 'lang:igniter.user::default.account.label_city', 'required|min:2|max:128'],
            ['address.state', 'lang:igniter.user::default.account.label_state', 'max:128'],
            ['address.postcode', 'lang:igniter.user::default.account.label_postcode', 'min:2|max:11'],
            ['address.country_id', 'lang:igniter.user::default.account.label_country', 'required|integer'],
        ];

        if (!$this->validatePasses($data, $rules)) {
            return $this->onLoadAddForm();
        }

        $customer = Auth::customer();

        $address = null;
        if ($id = array_get($data, 'address.address_id')) {
            $address = Address::find($id);
        }

        if (!$address || $address->customer_id != $customer->customer_id) {
            $address = Address::make();
        }

        $address->fill(array_get($data, 'address'));
        $address->customer_id = $customer->customer_id;
        $address->save();

        flash()->success(lang('igniter.user::default.account.alert_updated_success'))->now();

        if (is_numeric($this->param('addressId'))) {
            return Redirect::to($this->controller->pageUrl(
                $this->property('redirectPage', 'account/address'),
                ['addressId' => null]
            ));
        }

        $this->pageCycle();

        return [
            '#address-book' => $this->renderPartial('@default'),
        ];
    }

    public function onDelete()
    {
        $addressId = post('addressId');
        if (!$addressId || !is_numeric($addressId)) {
            return;
        }

        if (!$address = Address::find($addressId)) {
            return;
        }

        $address->customer_id = null;
        $address->save();

        flash()->success(lang('igniter.user::default.account.alert_deleted_success'))->now();

        return redirect()->back();
    }

    protected function getAddress()
    {
        if (!is_numeric($addressIdParam = $this->param('addressId'))) {
            return null;
        }

        $customer = Auth::customer();
        $address = Address::find($addressIdParam);
        if (!$customer || $address->customer_id != $customer->customer_id) {
            return null;
        }

        return $address;
    }

    protected function setDefaultAddress()
    {
        $customer = Auth::customer();

        $customer->address_id = $this->param('addressId');
        $customer->save();

        return Redirect::back();
    }

    protected function loadAddressBook()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->addresses()->listFrontEnd([
            'page' => $this->param('page'),
            'pageLimit' => $this->property('itemsPerPage'),
            'sort' => $this->property('sortOrder', 'created_at desc'),
        ]);
    }
}
