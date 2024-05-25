<?php

function request_string($name)
{

    if (!array_key_exists($name, $_POST)) {
        return '';
    }

    $value = $_POST[$name];
    if (!is_string($value)) {
        return '';
    }

    return $value;
}
