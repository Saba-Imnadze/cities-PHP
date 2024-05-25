<?php

function country_filter($conn, $country_id)
{

    $country_sql = "SELECT * FROM `country`";
    $country_result = mysqli_query($conn, $country_sql);
    $country_row = iterator_to_array($country_result);

    $body = '<label for="country_id"> Country:</label>' .
        '<select id="country_id" name="country_id">' . '<option></option>';
    foreach ($country_row as $country) {
        $body .= '<option value="' . htmlspecialchars($country['id']) . '"' . ($country_id == $country['id'] ? ' selected' : '') . '>' . htmlspecialchars($country['name']) . '</option>';
    }
    $body .= '</select>';
    return $body;
}
