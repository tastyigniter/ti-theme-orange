<div class="mb-3">
    <div @class(['form-floating', 'is-invalid' => has_form_error('form.comment')])>
        <textarea
            wire:model="form.comment"
            data-checkout-control="comment"
            name="comment"
            id="comment"
            rows="3"
            @class(['form-control', 'is-invalid' => has_form_error('form.comment')])
            placeholder="@lang('igniter.cart::default.checkout.label_comment')"
            aria-describedby="commentFeedback"
        ></textarea>
        <label for="comment">@lang('igniter.cart::default.checkout.label_comment')</label>
    </div>
    <x-igniter-orange::forms.error field="form.comment" id="commentFeedback" class="text-danger"/>
</div>
