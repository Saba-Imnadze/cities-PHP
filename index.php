<?php
include_once "init.php";

$q = request_q();
$population_id = request_population_id($conn);
$continent_id = request_continent_id($conn);
$country_id = request_country_id($conn);
$visa_free = request_visa_free();
$direct_flight = request_direct_flight();

$escaped_q = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q);

$limit = 10;
$page = max(1, isset($_GET['page']) ? abs((int) $_GET['page']) : 1);

if ($page < 1) {
    $page = 1;
}

$sql = "SELECT COUNT(*) count FROM `city` WHERE name LIKE '%" . mysqli_real_escape_string($conn, $escaped_q) . "%'";

if ($population_id !== 0) {
    $sql .= " AND population_id = $population_id";
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

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$totalPages = max(1, ceil($row['count'] / $limit));

if ($page > $totalPages) {
    header("location:index.php?page=1");
    exit;
}

$offset = ($page - 1) * $limit;

$rows = db_city_list($conn, $escaped_q, $population_id, $continent_id, $country_id, $visa_free, $direct_flight, $limit, $offset);

$body = '<div class="main_container">' .
'<h1>Cities</h1>' .
"<a href='" . SITE_BASE . "create/'>Add City</a>" .
filter($conn, $q, $population_id, $continent_id, $country_id, $visa_free, $direct_flight) .
city_list($conn, $rows, $totalPages, $q, $country_id, $population_id, $continent_id, $visa_free, $direct_flight);

echo_page([
    'body' => $body,
    'title' => "Cities",
]);
