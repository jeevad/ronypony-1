<?php
function random_mobile_number()
{
    for ($randomNumber = mt_rand(6, 9), $i = 1; $i < 10; $i++) {
        $randomNumber .= mt_rand(0, 9);
    }
    return $randomNumber;
}