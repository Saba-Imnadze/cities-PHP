<?php

function population_filter($conn, $size_id)
{

    $sql_size = "SELECT * FROM population";
    $result_size = mysqli_query($conn, $sql_size);
    $rows_size = iterator_to_array($result_size);

    $body = '<label for="population_id">Population:</label>' .
        '<select id="population_id" name="population_id">' . '<option></option>';
    foreach ($rows_size as $size) {
        $body .= '<option value="' . htmlspecialchars($size['id']) . '"' . ($size_id == $size['id'] ? ' selected' : '') . '>' . htmlspecialchars($size['name']) . '</option>';
    }
    $body .= '</select>';
    return $body;
}
