<?php

$defaultCountry = \System\Models\Countries_model::getDefault();
$defaultCurrency = app('currency')->getDefault();
Assets::putJsVars([
    'country' => [
        'name' => $defaultCountry->country_name,
        'iso_code_2' => $defaultCountry->iso_code_2,
        'iso_code_3' => $defaultCountry->iso_code_3,
        'format' => $defaultCountry->format,
    ],
    // add currency helper
    'currency' => [
        'symbol' => $defaultCurrency->currency_symbol,
        'symbol_position' => $defaultCurrency->symbol_position,
        'thousand_sign' => $defaultCurrency->thousand_sign,
        'decimal_sign' => $defaultCurrency->decimal_sign,
        'decimal_precision' => $defaultCurrency->decimal_position,
    ],
]);
