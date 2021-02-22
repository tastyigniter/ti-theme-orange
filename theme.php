<?php

// add currency helper
$defaultCurrency = app('currency')->getDefault();
Assets::putJsVars([
    'currency' => [
        'symbol' => $defaultCurrency->currency_symbol,
        'symbol_position' => $defaultCurrency->symbol_position,
        'thousand_sign' => $defaultCurrency->thousand_sign,
        'decimal_sign' => $defaultCurrency->decimal_sign,
        'decimal_precision' => $defaultCurrency->decimal_position,
    ],
]);
