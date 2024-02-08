<div class="mb-4">
    <div @class(['form-floating', 'is-invalid' => has_form_error('comment')])>
            <textarea
                wire:model="form.comment"
                name="comment"
                id="comment"
                rows="3"
                @class(['form-control', 'is-invalid' => has_form_error('comment')])
                placeholder="@lang('igniter.cart::default.checkout.label_comment')"
                aria-describedby="commentFeedback"
            ></textarea>
        <label for="comment">@lang('igniter.cart::default.checkout.label_comment')</label>
    </div>
    <x-igniter-orange::forms.error field="form.comment" id="commentFeedback" class="text-danger" />
</div>
