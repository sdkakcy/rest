<?php

if (!function_exists('formatNumber')) {
    function formatNumber(float $number, int $decimal = 2)
    {
        return number_format($number, $decimal, '.', '');
    }
}
