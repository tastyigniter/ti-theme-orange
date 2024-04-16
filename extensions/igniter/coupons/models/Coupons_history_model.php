<?php

namespace Igniter\Coupons\Models;

use Igniter\Flame\Database\Model;
use Illuminate\Support\Facades\Event;

/**
 * Coupons History Model Class
 */
class Coupons_history_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'igniter_coupons_history';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'coupon_history_id';

    protected $guarded = [];

    protected $appends = ['customer_name'];

    protected $casts = [
        'coupon_history_id' => 'integer',
        'coupon_id' => 'integer',
        'order_id' => 'integer',
        'customer_id' => 'integer',
        'min_total' => 'float',
        'amount' => 'float',
        'status' => 'boolean',
    ];

    public $relation = [
        'belongsTo' => [
            'customer' => \Admin\Models\Customers_model::class,
            'order' => \Admin\Models\Orders_model::class,
            'coupon' => \Igniter\Coupons\Models\Coupons_model::class,
        ],
    ];

    public $timestamps = true;

    public static $allowedSortingColumns = [
        'created_at desc', 'created_at asc',
    ];

    public static function redeem($orderId)
    {
        Coupons_history_model::query()
            ->where('order_id', $orderId)
            ->get()
            ->each(function ($couponHistory) {
                $couponHistory->update([
                    'status' => 1,
                    'created_at' => now(),
                ]);

                Event::fire('admin.order.couponRedeemed', [$couponHistory]);
            });
    }

    public function getCustomerNameAttribute($value)
    {
        return ($this->customer && $this->customer->exists) ? $this->customer->full_name : $value;
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', '1');
    }

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'customer' => null,
            'order_id' => null,
            'sort' => 'created_at desc',
        ], $options));

        $query->where('status', '>=', 1);

        if (strlen($customer_id)) {
            $query->where('customer_id', $customer_id);
        }

        if (strlen($order_id)) {
            $query->where('order_id', $order_id);
        }

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

    public function touchStatus()
    {
        $this->status = ($this->status < 1) ? 1 : 0;

        return $this->save();
    }

    /**
     * @param \Igniter\Flame\Cart\CartCondition $couponCondition
     * @param \Admin\Models\Orders_model $order
     * @return \Admin\Models\Coupons_history_model|bool
     */
    public static function createHistory($couponCondition, $order)
    {
        if (!$coupon = $couponCondition->getModel()) {
            return false;
        }

        $model = new static;
        $model->order_id = $order->getKey();
        $model->customer_id = $order->customer ? $order->customer->getKey() : null;
        $model->coupon_id = $coupon->coupon_id;
        $model->code = $coupon->code;
        $model->amount = $couponCondition->getValue();
        $model->min_total = $coupon->min_total;

        if ($model->fireSystemEvent('couponHistory.beforeAddHistory', [$model, $couponCondition, $order->customer, $coupon], true) === false) {
            return false;
        }

        $model->save();

        return $model;
    }
}
