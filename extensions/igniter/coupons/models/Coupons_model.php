<?php

namespace Igniter\Coupons\Models;

use Admin\Models\Customer_groups_model;
use Admin\Traits\Locationable;
use Carbon\Carbon;
use Igniter\Flame\Auth\Models\User;
use Igniter\Flame\Database\Model;

/**
 * Coupons Model Class
 */
class Coupons_model extends Model
{
    use Locationable;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'igniter_coupons';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'coupon_id';

    protected $timeFormat = 'H:i';

    public $timestamps = true;

    protected $casts = [
        'discount' => 'float',
        'min_total' => 'float',
        'redemptions' => 'integer',
        'customer_redemptions' => 'integer',
        'status' => 'boolean',
        'period_start_date' => 'date',
        'period_end_date' => 'date',
        'fixed_date' => 'date',
        'fixed_from_time' => 'time',
        'fixed_to_time' => 'time',
        'recurring_from_time' => 'time',
        'recurring_to_time' => 'time',
        'order_restriction' => 'array',
        'auto_apply' => 'boolean',
    ];

    public $relation = [
        'belongsToMany' => [
            'categories' => [\Admin\Models\Categories_model::class, 'table' => 'igniter_coupon_categories'],
            'menus' => [\Admin\Models\Menus_model::class, 'table' => 'igniter_coupon_menus'],
            'customers' => [\Admin\Models\Customers_model::class, 'table' => 'igniter_coupon_customers'],
            'customer_groups' => [\Admin\Models\Customer_groups_model::class, 'table' => 'igniter_coupon_customer_groups'],
        ],
        'hasMany' => [
            'history' => \Igniter\Coupons\Models\Coupons_history_model::class,
        ],
        'morphToMany' => [
            'locations' => [\Admin\Models\Locations_model::class, 'name' => 'locationable'],
        ],
    ];

    public static $allowedSortingColumns = [
        'name desc', 'name asc',
        'coupon_id desc', 'coupon_id asc',
        'code desc', 'code asc',
    ];

    public function getRecurringEveryOptions()
    {
        return ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    }

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('name');
    }

    //
    // Accessors & Mutators
    //

    public function getRecurringEveryAttribute($value)
    {
        return empty($value) ? [0, 1, 2, 3, 4, 5, 6] : explode(', ', $value);
    }

    public function setRecurringEveryAttribute($value)
    {
        $this->attributes['recurring_every'] = empty($value)
            ? null : implode(', ', $value);
    }

    public function getTypeNameAttribute($value)
    {
        return ($this->type == 'P') ? lang('igniter.coupons::default.text_percentage') : lang('igniter.coupons::default.text_fixed_amount');
    }

    public function getFormattedDiscountAttribute($value)
    {
        return ($this->type == 'P') ? round($this->discount).'%' : number_format($this->discount, 2);
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'sort' => 'id desc',
        ], $options));

        $query->where('status', '>=', 1);

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        $this->fireEvent('model.extendListFrontEndQuery', [$query]);

        return $query->paginate($pageLimit, $page);
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', '1');
    }

    public function scopeIsAutoApplicable($query)
    {
        return $query->where('auto_apply', '1');
    }

    public function scopeWhereHasCategory($query, $categoryId)
    {
        $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.category_id', $categoryId);
        });
    }

    public function scopeWhereHasMenu($query, $menuId)
    {
        $query->whereHas('menus', function ($q) use ($menuId) {
            $q->where('menus.menu_id', $menuId);
        });
    }

    public function scopeWhereCodeAndLocation($query, $code, $locationId)
    {
        $query->whereHasOrDoesntHaveLocation($locationId)->whereCode($code);
    }

    //
    // Events
    //

    protected function beforeDelete()
    {
        $this->categories()->detach();
        $this->menus()->detach();
    }

    /**
     * Create new or update existing menu categories
     *
     * @param array $categoryIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenuCategories(array $categoryIds = [])
    {
        if (!$this->exists) {
            return false;
        }

        $this->categories()->sync($categoryIds);
    }

    /**
     * Create new or update existing menus
     *
     * @param array $menuIds if empty all existing records will be deleted
     *
     * @return bool
     */
    public function addMenus(array $menuIds = [])
    {
        if (!$this->exists) {
            return false;
        }

        $this->menus()->sync($menuIds);
    }

    //
    // Helpers
    //

    public function isFixed()
    {
        return $this->type == 'F';
    }

    public function discountWithOperand()
    {
        return ($this->isFixed() ? '-' : '-%').$this->discount;
    }

    public function minimumOrderTotal()
    {
        return $this->min_total ?: 0;
    }

    /**
     * Check if a coupone is expired
     *
     * @param Carbon\Carbon $orderDateTime orderDateTime
     *
     * @return bool
     */
    public function isExpired($orderDateTime = null)
    {
        if (is_null($orderDateTime)) {
            $orderDateTime = Carbon::now();
        }

        switch ($this->validity) {
            case 'forever':
                return false;
            case 'fixed':
                $start = $this->fixed_date->copy()->setTimeFromTimeString($this->fixed_from_time);
                $end = $this->fixed_date->copy()->setTimeFromTimeString($this->fixed_to_time);

                return !$orderDateTime->between($start, $end);
            case 'period':
                return !$orderDateTime->between($this->period_start_date, $this->period_end_date);
            case 'recurring':
                if (!in_array($orderDateTime->format('w'), $this->recurring_every)) {
                    return true;
                }

                $start = $orderDateTime->copy()->setTimeFromTimeString($this->recurring_from_time);
                $end = $orderDateTime->copy()->setTimeFromTimeString($this->recurring_to_time);

                return !$orderDateTime->between($start, $end);
        }

        return false;
    }

    public function hasRestriction($orderType)
    {
        if (empty($this->order_restriction)) {
            return false;
        }

        return !in_array($orderType, $this->order_restriction);
    }

    public function hasLocationRestriction($locationId)
    {
        if (!$this->locations || $this->locations->isEmpty()) {
            return false;
        }

        $locationKeyColumn = $this->locations()->getModel()->qualifyColumn('location_id');

        return !$this->locations()->where($locationKeyColumn, $locationId)->exists();
    }

    public function hasReachedMaxRedemption()
    {
        return $this->redemptions && $this->redemptions <= $this->countRedemptions();
    }

    public function customerHasMaxRedemption(User $user)
    {
        return $this->customer_redemptions && $this->customer_redemptions <= $this->countCustomerRedemptions($user->getKey());
    }

    public function customerCanRedeem(?User $user = null)
    {
        if (!$this->customers || $this->customers->isEmpty()) {
            return true;
        }

        return $user && $this->customers->contains('customer_id', $user->getKey());
    }

    public function customerGroupCanRedeem(?Customer_groups_model $group = null)
    {
        if (!$this->customer_groups || $this->customer_groups->isEmpty()) {
            return true;
        }

        return $group && $this->customer_groups->contains('customer_group_id', $group->getKey());
    }

    public function countRedemptions()
    {
        return $this->history()->isEnabled()->count();
    }

    public function countCustomerRedemptions($id)
    {
        return $this->history()->isEnabled()
            ->where('customer_id', $id)->count();
    }

    public function appliesOnWholeCart()
    {
        return $this->apply_coupon_on == 'whole_cart';
    }

    public function appliesOnMenuItems()
    {
        return $this->apply_coupon_on == 'menu_items';
    }

    public function appliesOnDelivery()
    {
        return $this->apply_coupon_on == 'delivery_fee';
    }

    public static function getByCode($code)
    {
        return self::isEnabled()->whereCode($code)->first();
    }

    public static function getByCodeAndLocation($code, $locationId)
    {
        return self::isEnabled()->whereCodeAndLocation($code, $locationId)->first();
    }
}
