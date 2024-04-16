or login with
@foreach ($socialiteLinks as $name => $link)
    <a
        href="{{ $link."?success={$successPage}&error={$errorPage}" }}"
    ><i class="fab fa-2x fa-{{ $name }}"></i></a>
@endforeach