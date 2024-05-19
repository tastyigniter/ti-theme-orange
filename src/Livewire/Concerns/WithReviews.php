<?php

namespace Igniter\Orange\Livewire\Concerns;

use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\System\Facades\Assets;
use Livewire\WithPagination;

trait WithReviews
{
    use WithPagination;

    public int $itemPerPage = 20;

    public string $sortOrder = 'created_at desc';

    public function mountListReviews()
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');
    }

    protected function loadReviewList($page = null)
    {
        if (!$location = Location::current()) {
            return null;
        }

        return ReviewModel::with(['customer', 'customer.address'])
            ->isApproved()
            ->listFrontEnd([
                'page' => $page ?? $this->getPage(),
                'pageLimit' => $this->itemPerPage,
                'sort' => $this->sortOrder,
                'location' => $location->getKey(),
            ]);
    }

    public static function getSortOrderOptionsWithReviews(): array
    {
        return collect(ReviewModel::make()->queryModifierGetSorts())->mapWithKeys(function($value, $key) {
            return [$value => $value];
        })->all();
    }
}
