<div class="d-flex flex-row mb-3">
    @foreach ($listSorting as $key => $sorting)
        <a
                @class(['btn bg-white rounded-pill text-primary shadow-sm py-1 px-3 me-2 text-decoration-none', ' border-primary active' => $key == $activeSortBy])
                href="{{ $sorting['href'] }}"
        >{{ $sorting['name'] }}</a>
    @endforeach
</div>
