<?php

if (!function_exists('price_format')) {
    /**
     * Вывести число в виде цены
     * @param float $value
     * @return string
     */
    function price_format(float $value): string
    {
        return $value == floor($value) ? (int)$value : $value;
    }
}
