<ul class="autocomplete-suggestions">
    @forelse($suggestions as $key => $suggestion)
        <li
            wire:click="selectSuggestion({{ $key }})">
            @if($suggestion['title'])
                <div class="fw-bold">{{ $suggestion['title'] }}</div>
            @endif
            @if($suggestion['description'])
                <div>{{ $suggestion['description'] }}</div>
            @endif
        </li>
    @empty
        <li class="text-center">
            No suggestions found
        </li>
    @endforelse
</ul>
