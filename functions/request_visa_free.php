<?php

function request_visa_free()
{
    if (array_key_exists('visa_free', $_GET)) {
        $visa_free = $_GET['visa_free'];
        if (!in_array($visa_free, ['0', '1'])) {
            $visa_free = null;
        }
    } else {
        $visa_free = null;
    }
    return $visa_free;
}