<?php

namespace Igniter\Coupons\Requests;

use System\Classes\FormRequest;

class Coupon extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => lang('admin::lang.label_name'),
            'code' => lang('igniter.coupons::default.label_code'),
            'type' => lang('admin::lang.label_type'),
            'discount' => lang('igniter.coupons::default.label_discount'),
            'min_total' => lang('igniter.coupons::default.label_min_total'),
            'redemptions' => lang('igniter.coupons::default.label_redemption'),
            'customer_redemptions' => lang('igniter.coupons::default.label_customer_redemption'),
            'description' => lang('admin::lang.label_description'),
            'validity' => lang('igniter.coupons::default.label_validity'),
            'fixed_date' => lang('igniter.coupons::default.label_fixed_date'),
            'fixed_from_time' => lang('igniter.coupons::default.label_fixed_from_time'),
            'fixed_to_time' => lang('igniter.coupons::default.label_fixed_to_time'),
            'period_start_date' => lang('igniter.coupons::default.label_period_start_date'),
            'period_end_date' => lang('igniter.coupons::default.label_period_end_date'),
            'recurring_every' => lang('igniter.coupons::default.label_recurring_every'),
            'recurring_from_time' => lang('igniter.coupons::default.label_recurring_from_time'),
            'recurring_to_time' => lang('igniter.coupons::default.label_recurring_to_time'),
            'order_restriction.*' => lang('igniter.coupons::default.label_order_restriction'),
            'status' => lang('admin::lang.label_status'),
            'locations.*' => lang('admin::lang.column_location'),
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'between:2,128'],
            'code' => ['required', 'min:2', 'unique:igniter_coupons,code'],
            'type' => ['required', 'string', 'size:1'],
            'discount' => ['required', 'numeric', 'max:100'],
            'min_total' => ['numeric'],
            'redemptions' => ['required', 'integer'],
            'customer_redemptions' => ['required', 'integer'],
            'description' => ['max:1028'],
            'validity' => ['required', 'in:forever,fixed,period,recurring'],
            'fixed_date' => ['nullable', 'required_if:validity,fixed', 'date'],
            'fixed_from_time' => ['nullable', 'required_if:validity,fixed', 'valid_time'],
            'fixed_to_time' => ['nullable', 'required_if:validity,fixed', 'valid_time'],
            'period_start_date' => ['nullable', 'required_if:validity,period', 'date'],
            'period_end_date' => ['nullable', 'required_if:validity,period', 'date'],
            'recurring_every' => ['nullable', 'required_if:validity,recurring'],
            'recurring_from_time' => ['nullable', 'required_if:validity,recurring', 'valid_time'],
            'recurring_to_time' => ['nullable', 'required_if:validity,recurring', 'valid_time'],
            'order_restriction.*' => ['nullable', 'string'],
            'status' => ['boolean'],
            'locations.*' => ['integer'],
        ];
    }

    protected function prepareMaxRule($parameters, $field)
    {
        if ($field === 'discount' && $this->inputWith('type') != 'P') {
            return '';
        }

        return 'max:'.implode(',', $parameters);
    }
}
