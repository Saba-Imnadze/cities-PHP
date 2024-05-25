<?php

function city_form($conn, $action, $name, $country_id, $population_id, $continent_id, $visa_free, $direct_flight)
{

    $selected_country_id = array_key_exists('country_id', $_SESSION) ? $_SESSION['country_id'] : $country_id;
    $selected_population_id = array_key_exists('population_id', $_SESSION) ? $_SESSION['population_id'] : $population_id;
    $selected_continent_id = array_key_exists('continent_id', $_SESSION) ? $_SESSION['continent_id'] : $continent_id;
    $selected_visa_free = array_key_exists('visa_free', $_SESSION) ? $_SESSION['visa_free'] : $visa_free;
    $selected_direct_flight = array_key_exists('direct_flight', $_SESSION) ? $_SESSION['direct_flight'] : $direct_flight;

    $countries = iterator_to_array(mysqli_query($conn, 'select * from country'));
    $populations = iterator_to_array(mysqli_query($conn, 'select * from population'));
    $continents = iterator_to_array(mysqli_query($conn, 'select * from continent'));

    $body =
    '<form action="' . htmlspecialchars($action) . '" method="post" enctype="multipart/form-data">' .
    show_errors() .
    '<label for="name">Title:</label>' .
    '<input name="name" value="' . htmlspecialchars(isset($_SESSION['name']) ? $_SESSION['name'] : $name) . '">' .
        '<label for="country_id">Country:</label>' .
        '<select name="country_id">' .
        '<option></option>';

    foreach ($countries as $country) {
        $selected = $selected_country_id == $country['id'] ? 'selected' : '';
        $body .= '<option value="' . htmlspecialchars($country['id']) . '" ' . $selected . '>' .
        htmlspecialchars($country['name']) .
            '</option>';
    }

    $body .= '</select>' .
        '<label for="population_id">Population:</label>' .
        '<select name="population_id">' .
        '<option></option>';

    foreach ($populations as $population) {
        $selected = $selected_population_id == $population['id'] ? 'selected' : '';
        $body .= '<option value="' . htmlspecialchars($population['id']) . '" ' . $selected . '>' .
        htmlspecialchars($population['name']) .
            '</option>';
    }

    $body .= '</select>' .
        '<label for="continent_id">Continent:</label>' .
        '<select name="continent_id">' .
        '<option></option>';

    foreach ($continents as $continent) {
        $selected = $selected_continent_id == $continent['id'] ? 'selected' : '';
        $body .= '<option value="' . htmlspecialchars($continent['id']) . '" ' . $selected . '>' .
        htmlspecialchars($continent['name']) .
            '</option>';
    }

    $body .= '</select>' .
        '<label for="city_img">Image:</label>' .
        '<input type="file" name="city_img">' .

        "<div class='visa_free_radio'>" .
        '<label>Visa free:</label>' .
        '<label>' .
        '<input type="radio" name="visa_free" value="y"' . ($selected_visa_free === 'y' ? ' checked' : '') . '> Yes' .
        '</label>' .
        '<label>' .
        '<input type="radio" name="visa_free" value="n"' . ($selected_visa_free === 'n' ? ' checked' : '') . '> No' .
        '</label>' .
        "</div>" .
        "<div class='direct_flight_radio'>" .
        '<label>Direct flight:</label>' .
        '<label>' .
        '<input type="radio" name="direct_flight" value="y"' . ($selected_direct_flight === 'y' ? ' checked' : '') . '> Yes</label>' .
        '<label>' .
        '<input type="radio" name="direct_flight" value="n"' . ($selected_direct_flight === 'n' ? ' checked' : '') . '> No</label>' .
        '</div>' .
        '<button type="submit">Save</button>' .
        '</form>';

    unset($_SESSION['name']);
    unset($_SESSION['country_id']);
    unset($_SESSION['population_id']);
    unset($_SESSION['continent_id']);
    unset($_SESSION['visa_free']);
    unset($_SESSION['direct_flight']);

    return $body;

}
