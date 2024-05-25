<?php
include_once "../init.php";
if (!array_key_exists('id', $_GET)) {
    header("location:../index.php");
    exit;
}

$id = $_GET['id'];

if (!is_string($id)) {
    header("location:./");
    exit;
}

$id = (int) $id;

$sql_size = "SELECT * FROM population";
$result_size = mysqli_query($conn, $sql_size);
$rows_size = iterator_to_array($result_size);

$sql = "SELECT * FROM `city` WHERE id =" . $id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$sql_continent = "SELECT * FROM `continent`";
$result_continent = mysqli_query($conn, $sql_continent);
$rows_continents = iterator_to_array($result_continent);

$sql_country = "SELECT * FROM `country`";
$result_country = mysqli_query($conn, $sql_country);
$rows_country = iterator_to_array($result_country);

if ($row === null) {
    header('location:../');
}

$body = '<div class="main_container">' .

'<h1>' .
htmlspecialchars($row['name']) . '</h1>' .

"<a href='" . SITE_BASE . "'>Back</a>" .
'<div class="inner_container">' .
city_form($conn,
    'submit.php?id=' . $row['id'],
    $row['name'],
    $row['country_id'],
    $row['population_id'],
    $row['continent_id'],
    $row['visa_free'] ? 'y' : 'n',
    $row['direct_flight'] ? 'y' : 'n') .
    '</div>' .
    '</div>';

echo_page([
    'body' => $body,
    "title" => $row['name'],
]);
