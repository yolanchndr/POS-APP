<?php

if (!function_exists('is_logged_in')) {
    function is_logged_in(): bool
    {
        return session()->has('user_id');
    }
}


if (!function_exists('is_admin')) {
    function is_admin(): bool
    {
        return session()->get('level') === '1';
    }
}


if (!function_exists('is_kasir')) {
    function is_kasir(): bool
    {
        return session()->get('level') === '2';
    }
}


if (!function_exists('user_level')) {
    function user_level(): string
    {
        return session()->get('level') ?? '';
    }
}


if (!function_exists('user_name')) {
    function user_name(): string
    {
        return session()->get('name') ?? '';
    }
}