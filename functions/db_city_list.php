<?php

function db_city_list($conn, $escaped_q, $size_id, $continent_id, $country_id, $visa_free, $direct_flight, $limit, $offset)
{
    $sql = "SELECT * FROM `city` WHERE name LIKE '%" . mysqli_real_escape_string($conn, $escaped_q) . "%'";

    if ($size_id !== 0) {
        $sql .= " AND size_id = $size_id";
    }

    if ($continent_id !== 0) {
        $sql .= " AND continent_id = $continent_id";
    }
    if ($country_id !== 0) {
        $sql .= " AND country_id = $country_id";
    }

    if ($visa_free !== null) {
        $sql .= " AND visa_free = $visa_free";
    }
    if ($direct_flight !== null) {
        $sql .= " AND direct_flight = $direct_flight";
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    $result = mysqli_query($conn, $sql);
    $rows = iterator_to_array($result);
    return $rows;
}
