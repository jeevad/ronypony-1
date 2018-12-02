<?php
if (!function_exists('is_production')) {

    function is_production()
    {
        return app()->environment() === 'production';
    }
}

if (!function_exists('valid_email')) {

    function valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists('valid_mobile_number')) {

    function valid_mobile_number($mobileNumber)
    {
        return preg_match('/^[6789]\d{9}$/', $mobileNumber);
    }
}

if (!function_exists('logo_url')) {

    function logo_url()
    {
        return asset("assets/front/images/icons/logo.png");
    }
}
