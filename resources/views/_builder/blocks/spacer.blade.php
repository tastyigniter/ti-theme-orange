@php($padding = ['sm' => 'py-2', 'md' => 'py-4', 'lg' => 'py-5'][$settings['size']] ?? 'py-4')
<div class="{{ $padding }}" aria-hidden="true">
    @if($settings['divider'])
        <hr class="my-0"/>
    @endif
</div>
