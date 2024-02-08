<?php

namespace Igniter\Orange\Data;

use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location;

class MenuItemData
{
    public string $id;

    public string $name;

    public string $description;

    protected ?float $price = null;

    public ?float $priceBeforeSpecial = null;

    protected ?bool $mealtimeIsAvailable = null;

    public function __construct(public Menu $model)
    {
        $this->id = $model->getBuyableIdentifier();
        $this->name = $model->getBuyableName();
        $this->description = nl2br($model->menu_description ?? '');
        $this->priceBeforeSpecial = $model->menu_price;
    }

    public function price()
    {
        if (!is_null($this->price)) {
            return $this->price;
        }

        return $this->price = $this->model->special?->active()
            ? $this->model->special->getMenuPrice($this->model->menu_price)
            : $this->model->menu_price;
    }

    public function hasAllergens()
    {
        return $this->allergens()->isNotEmpty();
    }

    public function allergens()
    {
        return $this->model->ingredients->where('status', 1)->where('is_allergen', 1);
    }

    public function mealtimeIsAvailable()
    {
        if (!is_null($this->mealtimeIsAvailable)) {
            return $this->mealtimeIsAvailable;
        }

        return $this->mealtimeIsAvailable = $this->model->isAvailable(Location::orderDateTime());
    }

    public function hasOptions()
    {
        return $this->model->hasOptions();
    }

    public function hasThumb()
    {
        return $this->model->hasMedia('thumb');
    }

    public function getThumb(array $options = [], ?string $tag = null)
    {
        return $this->model->getThumb($options, $tag);
    }

    public function specialIsActive()
    {
        return $this->model->special?->active();
    }

    public function specialDaysRemaining()
    {
        return $this->model->special?->daysRemaining();
    }

    public function mealtimeTitles()
    {
        $titles = [];
        foreach ($this->model->mealtimes ?? [] as $mealtime) {
            $titles[] = sprintf(
                lang('igniter.local::default.text_mealtime'),
                $mealtime->mealtime_name,
                now()->setTimeFromTimeString($mealtime->start_time)->isoFormat(lang('system::lang.moment.time_format')),
                now()->setTimeFromTimeString($mealtime->end_time)->isoFormat(lang('system::lang.moment.time_format'))
            );
        }

        return implode("\r\n", $titles);
    }
}
