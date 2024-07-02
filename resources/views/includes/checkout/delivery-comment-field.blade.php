<div class="">
    <div @class(['form-floating', 'is-invalid' => has_form_error('form.delivery_comment')])>
        <textarea
            wire:model="form.delivery_comment"
            data-checkout-control="delivery_comment"
            id="deliveryComment"
            rows="3"
            @class(['form-control', 'is-invalid' => has_form_error('form.delivery_comment')])
            placeholder="@lang('igniter.cart::default.checkout.label_comment')"
            aria-describedby="deliveryCommentFeedback"
        ></textarea>
    <label for="deliveryComment">@lang('igniter.cart::default.checkout.label_delivery_comment')</label>
    </div>
    <x-igniter-orange::forms.error field="form.delivery_comment" id="deliveryCommentFeedback" class="text-danger" />
</div>
