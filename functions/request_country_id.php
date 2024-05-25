<?php

function request_country_id($conn)
{
    if (array_key_exists('country_id', $_GET)) {
        $country_id = $_GET['country_id'];
        if (is_string($country_id)) {
            $country_id = (int) $country_id;
            $country_id = abs($country_id);
            $sql = "select * from country where id = $country_id";
            $result = mysqli_query($conn, $sql);
            $country = mysqli_fetch_assoc($result);
            if ($country === null) {
                $country_id = 0;
            }

        } else {
            $country_id = 0;
        }
    } else {
        $country_id = 0;
    }
    return $country_id;
}
