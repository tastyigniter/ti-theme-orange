<?php

namespace Igniter\Orange\Livewire;

use Igniter\Cart\Classes\OrderManager;
use Igniter\Flame\Database\Model;
use Igniter\Local\Models\Review as ReviewModel;
use Igniter\Local\Models\ReviewSettings;
use Igniter\Main\Traits\UsesPage;
use Igniter\Reservation\Classes\BookingManager;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LeaveReview extends \Livewire\Component
{
    use UsesPage;

    public string $type = 'order';

    /** The parameter name used for the review hash code */
    public string $hashParamName = 'hash';

    public string $reviewableHash;

    public ?string $comment = null;

    public int $delivery = 0;

    public int $quality = 0;

    public int $service = 0;

    protected ?Model $reviewable = null;

    protected ?Model $customerReview = null;

    public function render()
    {
        return view('igniter-orange::livewire.leave-review', [
            'allowReviews' => ReviewSettings::allowReviews(),
            'reviewable' => $this->reviewable(),
            'hasCustomerReview' => (bool)$this->loadReview(),
            'reviewRatingHints' => $this->getHints(),
        ]);
    }

    public function mount()
    {
        Assets::addCss('igniter.local::/css/starrating.css', 'starrating-css');
        Assets::addJs('igniter.local::/js/starrating.js', 'starrating-js');

        $this->reviewableHash = request()->route($this->hashParamName);

        $customerReview = $this->loadReview();
        $this->quality = $customerReview->quality ?? 0;
        $this->delivery = $customerReview->delivery ?? 0;
        $this->service = $customerReview->service ?? 0;
        $this->comment = $customerReview->review_text ?? '';
    }

    public function onLeaveReview()
    {
        $this->validate([
            'comment' => ['required', 'min:2', 'max:1028'],
            'delivery' => ['required', 'integer', 'min:0'],
            'quality' => ['required', 'integer', 'min:0'],
            'service' => ['required', 'integer', 'min:0'],
        ], [], [
            'comment' => lang('igniter.local::default.review.label_review'),
            'delivery' => lang('igniter.local::default.review.label_delivery'),
            'quality' => lang('igniter.local::default.review.label_quality'),
            'service' => lang('igniter.local::default.review.label_service'),
        ]);

        throw_unless(ReviewSettings::allowReviews(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_review_disabled'),
        ]));

        throw_unless($customer = Auth::customer(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_expired_login'),
        ]));

        throw_unless($reviewable = $this->getReviewable(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_review_not_found'),
        ]));

        throw_unless($reviewable->isCompleted(), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_review_status_history'),
        ]));

        throw_if($this->checkReviewableExists($reviewable), ValidationException::withMessages([
            'comment' => lang('igniter.local::default.review.alert_review_duplicate'),
        ]));

        $model = new ReviewModel();
        $model->location_id = $reviewable->location_id;
        $model->customer_id = $customer->customer_id;
        $model->author = $customer->full_name;
        $model->sale_id = $reviewable->getKey();
        $model->sale_type = $reviewable->getMorphClass();
        $model->quality = $this->quality;
        $model->delivery = $this->delivery;
        $model->service = $this->service;
        $model->review_text = $this->comment;
        $model->review_status = ReviewSettings::autoApproveReviews();

        $model->save();

        flash()->success(lang('igniter.local::default.review.alert_review_success'))->now();
    }

    /**
     * @return mixed
     */
    protected function getHints()
    {
        return ReviewModel::make()->getRatingOptions();
    }

    protected function reviewable()
    {
        return $this->reviewable ??= $this->getReviewable();
    }

    protected function loadReview()
    {
        return $this->customerReview ??= ($this->reviewable() ? ReviewModel::whereReviewable($this->reviewable())->first() : null);
    }

    protected function getReviewable()
    {
        return match ($this->type) {
            'reservation' => resolve(BookingManager::class)->getReservationByHash($this->reviewableHash, Auth::customer()),
            'order' => resolve(OrderManager::class)->getOrderByHash($this->reviewableHash, Auth::customer()),
            default => null,
        };
    }

    protected function checkReviewableExists($reviewable)
    {
        if (!$customer = Auth::customer()) {
            return false;
        }

        return ReviewModel::checkReviewed($reviewable, $customer);
    }
}
