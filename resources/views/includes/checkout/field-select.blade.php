<div @class(['form-floating', 'is-invalid' => has_form_error($field->getName())])>
    <select
        wire:model="{{ $field->getName() }}"
        data-checkout-control="{{ $field->fieldName }}"
        id="{{ $field->getId() }}"
        @class(['form-select', 'is-invalid' => has_form_error($field->getName())])
        aria-describedby="{{ $field->getId() }}-feedback"
        {!! $field->getAttributes() !!}
    >
        <option value="">@lang('igniter::admin.text_please_select')</option>
        @foreach ($field->options() as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
    <label for="{{ $field->getId() }}">@lang($field->label)</label>
</div>
<x-igniter-orange::forms.error
    field="{{ $field->getName() }}"
    id="{{ $field->getId() }}-feedback"
    class="text-danger"
/>
