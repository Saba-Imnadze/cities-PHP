<?php

function continent_filter($conn, $continent_id)
{

    $continent_sql = "SELECT * FROM `continent`";
    $continent_result = mysqli_query($conn, $continent_sql);
    $continents_row = iterator_to_array($continent_result);

    $body = '<label for="continent_id"> Continent:</label>' .
        '<select id="continent_id" name="continent_id">' . '<option></option>';
    foreach ($continents_row as $continent) {
        $body .= '<option value="' . htmlspecialchars($continent['id']) . '"' . ($continent_id == $continent['id'] ? ' selected' : '') . '>' . htmlspecialchars($continent['name']) . '</option>';
    }
    $body .= '</select>';
    return $body;
}
