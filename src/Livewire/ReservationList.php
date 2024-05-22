<?php

namespace Igniter\Orange\Livewire;

use Igniter\Admin\Classes\FormField;
use Igniter\Admin\Widgets\Form;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\WithPagination;

class ReservationList extends \Livewire\Component
{
    use ConfigurableComponent;
    use UsesPage;
    use WithPagination;

    public int $itemsPerPage = 20;

    public string $sortOrder = 'reserve_date desc';

    public string $reservationPage = 'account.reservation';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::reservation-list',
            'name' => 'igniter.orange::default.component_reservation_list_title',
            'description' => 'igniter.orange::default.component_reservation_list_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'itemsPerPage' => [
                'label' => 'Number of reservations to display per page',
                'type' => 'number',
                'validationRule' => 'integer|min:1',
            ],
            'sortOrder' => [
                'label' => 'Sort order',
                'type' => 'select',
                'validationRule' => 'required|string',
            ],
            'reservationPage' => [
                'label' => 'Page name to display reservation details',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|string',
            ],
        ];
    }

    public static function getPropertyOptions(Form $form, FormField $field): array|Collection
    {
        return match ($field->getConfig('property')) {
            'sortOrder' => collect(Reservation::make()->queryModifierGetSorts())->mapWithKeys(function($value, $key) {
                return [$value => $value];
            })->all(),
            default => [],
        };
    }

    public function render()
    {
        return view('igniter-orange::livewire.reservation-list', [
            'allowReviews' => ReviewSettings::allowReviews(),
            'reservations' => $this->loadReservations(),
        ]);
    }

    protected function loadReservations()
    {
        if (!$customer = Auth::customer()) {
            return [];
        }

        return $customer->reservations()
            ->with(['location', 'status', 'tables'])
            ->listFrontEnd([
                'page' => $this->getPage(),
                'pageLimit' => $this->itemsPerPage,
                'sort' => $this->sortOrder,
            ]);
    }
}
