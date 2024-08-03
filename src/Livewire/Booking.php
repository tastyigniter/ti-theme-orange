<?php

namespace Igniter\Orange\Livewire;

use Carbon\Carbon;
use Igniter\Flame\Support\Facades\File;
use Igniter\Local\Facades\Location;
use Igniter\Main\Traits\ConfigurableComponent;
use Igniter\Main\Traits\UsesPage;
use Igniter\Orange\Livewire\Forms\BookingForm;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;

class Booking extends Component
{
    use ConfigurableComponent;
    use UsesPage;

    public const STEP_PICKER = 'picker';

    public const STEP_TIMESLOT = 'timeslot';

    public const STEP_BOOKING = 'booking';

    public BookingForm $form;

    /** Enable to display a calendar view for date selection */
    public bool $useCalendarView = true;

    /** Whether the telephone field should be required */
    public bool $telephoneIsRequired = true;

    /** Day of the week start the calendar. 0 (Sunday) to 6 (Saturday). */
    public int $weekStartOn = 0;

    /** The minimum guest size */
    public int $minGuestSize = 2;

    /** The maximum guest size */
    public int $maxGuestSize = 20;

    public int $noOfSlots = 6;

    /** Page to redirect to when checkout is successful */
    public string $successPage = 'reservation.success';

    public ?string $calendarLocale = null;

    #[Url(as: 'step')]
    public string $pickerStep = 'start';

    #[Url]
    public ?string $date = null;

    #[Url]
    public ?int $guest = null;

    #[Url]
    public ?string $time = null;

    public $startDate;

    public $endDate;

    /**
     * @var \Igniter\Reservation\Classes\BookingManager
     */
    protected $manager;

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::booking',
            'name' => 'igniter.orange::default.component_booking_title',
            'description' => 'igniter.orange::default.component_booking_desc',
        ];
    }

    public function defineProperties(): array
    {
        return [
            'useCalendarView' => [
                'label' => 'Use the calendar view for date selection.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'weekStartOn' => [
                'label' => 'Day of the week to start on. 0 (Sunday) to 6 (Saturday).',
                'type' => 'number',
                'validationRule' => 'required|integer|between:0,6',
            ],
            'minGuestSize' => [
                'label' => 'Minimum number of guests allowed for a reservation',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'maxGuestSize' => [
                'label' => 'Maximum number of guests allowed for a reservation.',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'noOfSlots' => [
                'label' => 'Number of time slots to display in the reduced timeslots view',
                'type' => 'number',
                'validationRule' => 'required|integer',
            ],
            'telephoneIsRequired' => [
                'label' => 'Require telephone number for booking.',
                'type' => 'switch',
                'validationRule' => 'required|boolean',
            ],
            'successPage' => [
                'label' => 'Page to redirect to when the booking is successful',
                'type' => 'select',
                'options' => [static::class, 'getThemePageOptions'],
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
        ];
    }

    public function render()
    {
        return view('igniter-orange::livewire.booking', [
            'customer' => Auth::customer(),
            'locationCurrent' => Location::current(),
        ]);
    }

    public function mount()
    {
        Assets::addCss('$/igniter/css/vendor.css', 'vendor-css');

        $this->calendarLocale = strtolower(str_before(str_before(app()->getLocale(), '_'), '-'));
        if ($this->calendarLocale != 'en') {
            if (File::symbolizePath($localPath = '$/igniter-orange/js/locales/flatpickr/'.$this->calendarLocale.'.js')) {
                Assets::addJs($localPath, 'flatpickr-locale-js');
            }
        }

        Assets::addCss('igniter.admin::css/formwidgets/datepicker.css', 'datepicker-css');
        Assets::addJs('igniter-orange::/js/booking.js', 'booking-js');
        Assets::addCss('igniter-orange::/css/booking.css', 'booking-css');

        $this->prepareProps();
    }

    public function boot()
    {
        $this->manager = resolve(BookingManager::class);
        $this->manager->useLocation(Location::current());
    }

    public function updating($name, $value)
    {
        if ($name === 'date') {
            unset($this->timeslots);
        }
    }

    public function onSave()
    {
        $this->pickerStep = static::STEP_PICKER;

        $this->validate([
            'guest' => 'required|integer|min:'.$this->minGuestSize.'|max:'.$this->maxGuestSize,
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
        ], [], [
            'guest' => lang('igniter.reservation::default.label_guest_num'),
            'date' => lang('igniter.reservation::default.label_date'),
            'time' => lang('igniter.reservation::default.label_time'),
        ]);

        $this->pickerStep = static::STEP_TIMESLOT;
    }

    public function onSelectTime(string $time)
    {
        $this->time = $time;

        $this->onSave();

        if ($this->pickerStep === static::STEP_TIMESLOT) {
            $this->pickerStep = static::STEP_BOOKING;
        }
    }

    public function onComplete()
    {
        $customer = Auth::customer();

        $this->form->validate();

        $reservation = $this->manager->loadReservation();

        $this->manager->saveReservation($reservation, [
            'sdateTime' => make_carbon($this->date.' '.$this->time)->format('Y-m-d H:i'),
            'guest' => $this->guest,
            'first_name' => $customer ? $customer->first_name : $this->form->firstName,
            'last_name' => $customer ? $customer->last_name : $this->form->lastName,
            'email' => $customer ? $customer->email : $this->form->email,
            'telephone' => $customer ? $customer->telephone : $this->form->telephone,
            'comment' => $this->form->comment,
        ]);

        $this->reset();

        return $this->redirect(page_url($this->successPage, ['hash' => $reservation->hash]));
    }

    #[Computed, Locked]
    public function timeslots(): Collection
    {
        return $this->manager->makeTimeSlots(make_carbon($this->date))
            ->map(fn($dateTime) => make_carbon($dateTime));
    }

    #[Computed, Locked]
    public function reducedTimeslots()
    {
        $timeslots = $this->timeslots->values();

        $selectedIndex = $timeslots->search(function(Carbon $slot) {
            return $slot->isSameAs('Y-m-d H:i', make_carbon($this->date.' '.$this->time));
        });

        if (($from = ($selectedIndex ?: 0) - ((int)($this->noOfSlots / 2) - 1)) < 0) {
            $from = 0;
        }

        return $timeslots
            ->slice($from, $this->noOfSlots - 1)
            ->map(function($dateTime, $index) use ($selectedIndex) {
                return (object)[
                    'dateTime' => $dateTime,
                    'fullyBooked' => false,
                    'isSelected' => $selectedIndex === $index,
                ];
            });
    }

    #[Computed, Locked]
    public function disabledDaysOfWeek()
    {
        return [];
    }

    #[Computed, Locked]
    public function disabledDates()
    {
        $result = [];
        $startDate = $this->startDate->copy();
        $endDate = $this->endDate->copy();
        $schedule = $this->manager->getSchedule();
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (!count($schedule->forDate($date))) {
                $result[] = $date->toDateString();
            }
        }

        return $result;
    }

    #[Computed, Locked]
    public function dates()
    {
        $start = $this->startDate->copy();
        $end = $this->endDate->copy();

        $options = [];
        $schedule = $this->manager->getSchedule();
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if (count($schedule->forDate($date))) {
                $options[] = $date->copy();
            }
        }

        return $options;
    }

    protected function prepareProps()
    {
        $location = Location::current();

        $this->startDate = now()->addDays($location->getMinReservationAdvanceTime())->startOfDay();
        $this->endDate = now()->addDays($location->getMaxReservationAdvanceTime())->endOfDay();
        $this->guest = $this->minGuestSize;
        $this->date = $this->startDate->format('Y-m-d');

        if ($customer = Auth::customer()) {
            $this->form->firstName = $customer->first_name;
            $this->form->lastName = $customer->last_name;
            $this->form->email = $customer->email;
            $this->form->telephone = $customer->telephone;
        }
    }
}
