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

    public ?int $minimumQuantity = 0;

    protected ?bool $mealtimeIsAvailable = null;

    public function __construct(public Menu $model)
    {
        $this->id = $model->getBuyableIdentifier();
        $this->name = $model->getBuyableName();
        $this->description = nl2br($model->menu_description ?? '');
        $this->priceBeforeSpecial = $model->menu_price;
        $this->minimumQuantity = $model->minimum_qty;
    }

    public function price()
    {
        if (!is_null($this->price)) {
            return $this->price;
        }

        return $this->price = $this->model->getBuyablePrice();
    }

    public function hasIngredients()
    {
        return $this->ingredients()->isNotEmpty();
    }

    public function ingredients()
    {
        return $this->model->ingredients->where('status', 1);
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

    public function getOptions()
    {
        return $this->model->menu_options->sortBy('priority');
    }

    public function hasThumb()
    {
        return $this->model->hasMedia('thumb');
    }

    public function getThumb(array $options = [], ?string $tag = null)
    {
        return $this->model->getThumbOrBlank($options, $tag);
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

    public function getUrl(?string $pageId = null)
    {
        $current = Location::current();
        $slug = $this->model->locations->first()?->permalink_slug;
        if ($current && ($this->model->locations->isEmpty() || $this->model->locations->firstWhere('location_id', $current->getKey()))) {
            $slug = $current->permalink_slug;
        }

        $url = page_url($pageId ?? 'local.menus', ['location' => $slug]);

        return $url.'?menuId='.$this->model->getBuyableIdentifier();
    }
}
