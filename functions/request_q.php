<?php

function request_q()
{
    if (array_key_exists('q', $_GET)) {
        $q = $_GET['q'];
        if (is_string($q)) {
            $q = trim($q);
        } else {
            $q = '';
        }
    } else {
        $q = '';
    }
    return $q;
}
