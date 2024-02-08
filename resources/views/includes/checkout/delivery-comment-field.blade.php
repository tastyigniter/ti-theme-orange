<div class="mb-4">
    <div @class(['form-floating', 'is-invalid' => has_form_error('deliveryComment')])>
            <textarea
                wire:model="form.deliveryComment"
                name="deliveryComment"
                id="deliveryComment"
                rows="3"
                @class(['form-control', 'is-invalid' => has_form_error('deliveryComment')])
                placeholder="@lang('igniter.cart::default.checkout.label_comment')"
                aria-describedby="deliveryCommentFeedback"
            ></textarea>
        <label for="deliveryComment">@lang('igniter.cart::default.checkout.label_delivery_comment')</label>
    </div>
    <x-igniter-orange::forms.error field="form.deliveryComment" id="deliveryCommentFeedback" class="text-danger" />
</div>
