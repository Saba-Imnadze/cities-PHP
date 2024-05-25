<?php

function city_list($conn, $cities, $totalPages, $q, $country_id, $population_id, $continent_id, $visa_free, $direct_flight)
{
    $body = '<div class="inner_container">';

    if ($cities) {
        foreach ($cities as $city) {
            $body .= city_item($conn, $city);
        }
    } else {
        $body .= '<div>Nothing to display</div>';
    }
    $body .= '</div>';

    $body .= '<div class="pagination">';

    for ($i = 1; $i <= $totalPages; $i++) {
        $query = http_build_query([
            'q' => $q,
            'country_id' => $country_id,
            'population_id' => $population_id,
            'continent_id' => $continent_id,
            'visa_free' => $visa_free,
            'direct_flight' => $direct_flight,
            'page' => $i,
        ]);
        $body .= "<a href='?" . htmlspecialchars($query) . "'>$i</a>";
    }

    $body .= '</div>';
    $body .= '</div>';
    return $body;
}
