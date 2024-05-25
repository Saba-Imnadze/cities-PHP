<?php
function filter($conn, $q, $size_id, $continent_id, $country_id, $visa_free, $direct_flight)
{
    return
    '<form class="search_form">' .
    '<div class="form-row">' .
    '<label for"q">' . "Title: " . '</label>' .
    '<input name="q" value="' . htmlspecialchars($q) . '" />' .
    '</div>' .
    '<div class="form-row">' .
    country_filter($conn, $country_id) .
    '</div>' .
    '<div class="form-row">' .
    population_filter($conn, $size_id) .
    '</div>' .
    '<div class="form-row">' .
    continent_filter($conn, $continent_id) .
        '</div>' .
        '<div class="form-row">' .
        '<label for="visa_free">Visa free:</label>' .
        '<select id="visa_free" name="visa_free">' .
        '<option value=""></option>' .
        '<option value="1"' . ($visa_free === '1' ? ' selected' : '') . '>Yes</option>' .
        '<option value="0"' . ($visa_free === '0' ? ' selected' : '') . '>No</option>' .
        '</select>' .
        '</div>' .
        '<div class="form-row">' .
        '<label for="direct_flight">Direct flight:</label>' .
        '<select id="direct_flight" name="direct_flight">' .
        '<option value=""></option>' .
        '<option value="1"' . ($direct_flight === '1' ? ' selected' : '') . '>Yes</option>' .
        '<option value="0"' . ($direct_flight === '0' ? ' selected' : '') . '>No</option>' .
        '</select>' .
        '</div>' .
        '<div class="form-row">' .
        '<button>Search</button>' .
        '</div>' .
        '</form>';
}
