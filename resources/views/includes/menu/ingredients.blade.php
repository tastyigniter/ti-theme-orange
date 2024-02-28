<div class="d-flex align-items-center ingredients">
    @foreach ($ingredients as $ingredient)
        <span
            @class([
                'badge badge-light text-dark px-2',
                'py-1' => !$ingredient->hasMedia('thumb'),
                'me-2' => !$loop->last
            ])
            data-bs-toggle="tooltip"
            title="{{ $ingredient->name }}: {{ $ingredient->description }}"
        >
        @if ($ingredient->hasMedia('thumb'))
                <img
                    class="img-fluid rounded-pill"
                    alt="{{ $ingredient->name }}"
                    src="{{ $ingredient->getThumb(['width' => $ingredientThumbWidth, 'height' => $ingredientThumbHeight]) }}"
                />
            @endif
            {{ $ingredient->name }}
    </span>
    @endforeach
</div>
