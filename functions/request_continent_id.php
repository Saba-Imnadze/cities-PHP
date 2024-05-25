<?php

function request_continent_id($conn)
{
    if (array_key_exists('continent_id', $_GET)) {
        $continent_id = $_GET['continent_id'];
        if (is_string($continent_id)) {
            $continent_id = (int) $continent_id;
            $continent_id = abs($continent_id);
            $sql = "select * from continent where id = $continent_id";
            $result = mysqli_query($conn, $sql);
            $continent = mysqli_fetch_assoc($result);
            if ($continent === null) {
                $continent_id = 0;
            }

        } else {
            $continent_id = 0;
        }
    } else {
        $continent_id = 0;
    }
    return $continent_id;
}