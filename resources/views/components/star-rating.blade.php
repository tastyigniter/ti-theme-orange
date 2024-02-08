@for ($value = 1; $value<6; $value++)
    <span @class([
        'fa-star',
        'fa' => $value <= $score,
        'far' => $value >= $score
     ])></span>
@endfor
