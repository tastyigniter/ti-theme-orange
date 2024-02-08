<div class="d-flex align-items-center allergens">
    @foreach ($allergens as $allergen)
        <span
            @class([
                'badge text-dark fw-normal rounded-pill shadow-sm px-2',
                'py-2' => !$allergen->hasMedia('thumb'),
                'me-2' => !$loop->last
            ])
            data-bs-toggle="tooltip"
            title="{{ $allergen->name }}: {{ $allergen->description }}"
        >
        @if ($allergen->hasMedia('thumb'))
                <img
                    class="img-fluid rounded-pill"
                    alt="{{ $allergen->name }}"
                    src="{{ $allergen->getThumb(['width' => $allergenThumbWidth, 'height' => $allergenThumbHeight]) }}"
                />
            @endif
            {{ $allergen->name }}
    </span>
    @endforeach
</div>
