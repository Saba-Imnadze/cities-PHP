<?php

function request_direct_flight()
{
    if (array_key_exists('direct_flight', $_GET)) {
        $direct_flight = $_GET['direct_flight'];
        if (!in_array($direct_flight, ['0', '1'])) {
            $direct_flight = null;
        }
    } else {
        $direct_flight = null;
    }
    return $direct_flight;
}
