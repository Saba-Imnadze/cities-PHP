<?php

function city_item($conn, $city)
{

    $sql = "select * from country where id = $city[country_id]";
    $country = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    return '<div class="city_row">' .
    '<div>' .
    '<img src="city-image/' . $city['id'] . '.jpg" alt="City image" width="200" height="150">' .
    '</div>' .
    '<div>' . htmlspecialchars($city['name']) . '</div>' .
    "<div>" . htmlspecialchars($country['name']) . "</div>" .
        "<div>Visa Free: " . ($city['visa_free'] ? 'Yes' : 'No') . "</div>" .
        '<div class="btn_container">' .
        '<a href="' . SITE_BASE . 'edit/?id=' . $city['id'] . '">Edit</a>' .
        '<a href="' . SITE_BASE . 'delete/?id=' . $city['id'] . '">Delete</a>' .
        '</div>' .
        '</div>';
}
