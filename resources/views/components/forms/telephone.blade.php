@props(['id', 'label', 'number', 'field', 'readOnly'])
<div @class(['form-control py-0', 'is-invalid' => has_form_error($field)])>
    <label for="{{$id}}">{{$label}}</label>
    <input
        data-control="country-code-picker"
        data-hidden-input-id="hidden-{{$id}}"
        data-container-class="w-100"
        id="{{$id}}"
        type="text"
        @class(['form-control shadow-none border-none'])
        aria-describedby="{{$id}}Feedback"
        value="{{$number}}"
        required
    />
</div>
<input
    type="hidden"
    id="hidden-{{$id}}"
    value="{{$number}}"
/>
<x-igniter-orange::forms.error field="{{$field}}" id="{{$id}}Feedback" class="text-danger"/>
@script
<script>
    const telephoneInput = document.querySelector('#hidden-{{$id}}');
    telephoneInput.addEventListener('telephoneChange', (event) => {
        $wire.{{ $field }} = telephoneInput.value
    })
</script>
@endscript
