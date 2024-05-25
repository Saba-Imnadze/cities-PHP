<?php
include_once "init.php";

$sql_size = "SELECT * FROM `size`";
$result_size = mysqli_query($conn, $sql_size);
$rows_size = iterator_to_array($result_size);

$continent_sql = "SELECT * FROM `continent`";
$continent_result = mysqli_query($conn, $continent_sql);
$continents_row = iterator_to_array($continent_result);

$q = '';
$pop_id = '';
$continent_id = '';

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    if (!is_string($q)) {
        $q = '';
    }
    $q = trim($q);
}

if (isset($_GET['population_id'])) {
    $pop_id = $_GET['population_id'];

    if ($pop_id !== '' && !is_numeric($pop_id)) {
        header("location:./");
        exit;
    }

    if ($pop_id !== '' && ($pop_id < 0 || $pop_id >= count($rows_size) + 1)) {
        header("location:./");
        exit;
    }
}

if (isset($_GET['continent_id'])) {
    $continent_id = $_GET['continent_id'];

    if ($continent_id !== '' && !is_numeric($continent_id)) {
        header("location:./");
        exit;
    }

    if ($continent_id !== '' && ($continent_id < 0 || $continent_id >= count($continents_row) + 1)) {
        header("location:./");
        exit;
    }
}

$escaped_q = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q);

$limit = 10;
$page = max(1, isset($_GET['page']) ? abs((int) $_GET['page']) : 1);

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT COUNT(*) AS count FROM `cities` WHERE city LIKE '%" . mysqli_real_escape_string($conn, $escaped_q) . "%'";

if ($pop_id !== '' && is_numeric($pop_id)) {
    $sql .= " AND size_id = " . (int) $pop_id;
}

if ($continent_id !== '' && is_numeric($continent_id)) {
    $sql .= " AND continent_id = " . (int) $continent_id;
}

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$totalPages = max(1, ceil($row['count'] / $limit));

if ($page > $totalPages) {
    header("location:index.php?page=1");
    exit;
}

$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM `cities` WHERE city LIKE '%" . mysqli_real_escape_string($conn, $escaped_q) . "%'";

if ($pop_id !== '' && is_numeric($pop_id)) {
    $sql .= " AND size_id = " . (int) $pop_id;
}

if ($continent_id !== '' && is_numeric($continent_id)) {
    $sql .= " AND continent_id = " . (int) $continent_id;
}

$sql .= " LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);
$rows = iterator_to_array($result);

$body = '<div class="main_container">' .
'<h1>Display Cities</h1>' .
"<a href='" . SITE_BASE . "create/'>Add City</a>" .
'<form>' .
'<label for"q">' . "Search City: " . '</label>' .
'<input name="q" value="' . htmlspecialchars($q) . '" />' .
    '<label for"country_search">' . "Search bt Country: " . '</label>' .
    '<input name="country_search" value="" />' .
    '<label for="population_id">Select population range:</label>' .
    '<select id="population_id" name="population_id">' . '<option></option>';

foreach ($rows_size as $size) {

    $body .= '<option value="' . htmlspecialchars($size['id']) . '"' . ($pop_id == $size['id'] ? ' selected' : '') . '>' . htmlspecialchars($size['population_range']) . '</option>';
}
$body .= '</select>' .
    '<label for="continent_id">Select Continent:</label>' .
    '<select id="continent_id" name="continent_id">' . '<option></option>';

foreach ($continents_row as $continent) {
    $body .= '<option value="' . htmlspecialchars($continent['id']) . '"' . ($continent_id == $continent['id'] ? ' selected' : '') . '>' . htmlspecialchars($continent['name']) . '</option>';
}

$body .= '</select>' .
    '<button>Search</button>' .
    '</form>' .
    '<div class="inner_container">';

if ($rows) {
    foreach ($rows as $row) {
        $body .= '<div class="city_row">' .
        '<h3>' . htmlspecialchars($row['city']) . '</h3>' .
        "<h3>" . htmlspecialchars($row['country']) . "</h3>" .
            '<div class="btn_container">' .
            '<a href="' . SITE_BASE . 'edit/?id=' . $row['id'] . '">Edit</a>' .
            '<a href="' . SITE_BASE . 'delete/?id=' . $row['id'] . '">Delete</a>' .
            '</div>' .
            '</div>';
    }
} else {
    $body .= '<div>Nothing to display</div>';
}

$body .= '</div>';

$body .= '<div class="pagination">';

for ($i = 1; $i <= $totalPages; $i++) {
    $query = http_build_query([
        'q' => $q,
        'page' => $i,
        'population_id' => $pop_id,
        'continent_id' => $continent_id,
    ]);
    $body .= "<a href='?" . htmlspecialchars($query) . "'>$i</a>";
}

$body .= '</div>';
$body .= '</div>';

echo_page([
    'body' => $body,
    'title' => "Main Page",
]);


////////////////////////

<?php

function show_errors()
{
    $html = '';
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        $html .= "<div class='Errors'>";
        foreach ($errors as $error) {
            $html .= "<div class='Errors-item'>";
            $html .= "<h3>" . htmlspecialchars($error) . "</h3>";
            $html .= "</div>";
        }
        $html .= "</div>";

        unset($_SESSION['errors']);
    }
    return $html;
}
11111111111111111111111111111111111111

<?php

include_once "../init.php";
$sql_size = "SELECT * FROM `size`";
$result_size = mysqli_query($conn, $sql_size);
$rows_size = iterator_to_array($result_size);

$sql_continent = "SELECT * FROM `continent`";
$result_continent = mysqli_query($conn, $sql_continent);
$rows_continents = iterator_to_array($result_continent);

$sql_country = "SELECT * FROM `country`";
$result_country = mysqli_query($conn, $sql_country);
$rows_country = iterator_to_array($result_country);

$body = '<div class="main_container">' .

'<h1>Create</h1>' .
"<a href='" . SITE_BASE . "'>Back</a>" .
'<div class="inner_container">' .
'<form action="submit.php" method="post">' .
show_errors() .
    '<label for="city">City:</label>' .
    '<input type="text" id="city" name="city" value="' . (isset($_SESSION['city']) ? $_SESSION['city'] : "") . '">' .
    '<label for="country">Country:</label>' .
    '<select id="country" name="country">' . '<option></option>';

foreach ($rows_country as $country) {
    $body .= '<option value="' . htmlspecialchars($country['id']) . '">' . htmlspecialchars($country['name']) . '</option>';
}

$body .= '</select>' .

    '<label for="population_id">Population:</label>' .
    '<select id="population_id" name="population_id">' . '<option></option>';

foreach ($rows_size as $size) {
    $body .= '<option value="' . htmlspecialchars($size['id']) . '">' . htmlspecialchars($size['range']) . '</option>';
}

$body .= '</select>' .

    '<label for="continent_id">Continent:</label>' .
    '<select id="continent_id" name="continent_id">' . '<option></option>';

foreach ($rows_continents as $continent) {
    $body .= '<option value="' . htmlspecialchars($continent['id']) . '">' . htmlspecialchars($continent['name']) . '</option>';
}

$body .= '</select>' .
    "<div class='visa_free_radio'>" .
    '<label>' .
    '<input type="radio" name="visa_free" value="1" checked> No Visa
</label>' .
    '<label>' .
    '<input type="radio" name="visa_free" value="0"> Visa
</label>' .
    "</div>" .
    "<div class='direct_flight_radio'>" .
    '<label>' .
    '<input type="radio" name="direct_flight" value="1" checked> Direct flight
</label>' .
    '<label>' .
    '<input type="radio" name="direct_flight" value="0"> No Direct flight
</label>' .
    '</div>' .
    '<button type="submit">Save</button>' .
    '</form>' .

    '</div>';

echo_page([
    'body' => $body,
    'title' => "Create",
]);
