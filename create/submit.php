<?php
include_once "../init.php";

if (!array_key_exists('city_img', $_FILES)) {
    header('Location: ' . SITE_BASE);
    die;
}

$city_img = $_FILES['city_img'];
if (!is_string($city_img['name'])) {
    header('Location: ' . SITE_BASE);
    die;
}

$name = request_string("name");
$country_id = abs((int) request_string("country_id"));
$population_id = abs((int) request_string("population_id"));
$continent_id = abs((int) request_string("continent_id"));
$visa_free = request_string("visa_free");
if (!in_array($visa_free, ['y', 'n'])) {
    $visa_free = null;
}
$direct_flight = request_string("direct_flight");
if (!in_array($direct_flight, ['y', 'n'])) {
    $direct_flight = null;
}

$sql = "select * from country where id = $country_id";
$country = mysqli_fetch_assoc(mysqli_query($conn, $sql));

$sql = "select * from population where id = $population_id";
$population = mysqli_fetch_assoc(mysqli_query($conn, $sql));

$sql = "select * from continent where id = $continent_id";
$continent = mysqli_fetch_assoc(mysqli_query($conn, $sql));

$_SESSION['name'] = $name;
$_SESSION['country_id'] = $country_id;
$_SESSION['population_id'] = $population_id;
$_SESSION['continent_id'] = $continent_id;
$_SESSION['visa_free'] = $visa_free;
$_SESSION['direct_flight'] = $direct_flight;

$errors = [];

if (empty($name)) {
    $errors[] = "Title field is empty";
}
if ($country === null) {
    $errors[] = "Country field is empty";
}
if ($population === null) {
    $errors[] = "Population field is empty";
}
if ($continent === null) {
    $errors[] = "Continent field is empty";
}
if ($city_img['error'] === UPLOAD_ERR_NO_FILE) {
    $errors[] = 'Select image';
} else {
    if ($city_img['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Image upload error';
    } else {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($city_img['type'], $allowed_types)) {
            $errors[] = "Only JPG, PNG, or JPG images are allowed";
        } elseif ($city_img['size'] > 5 * 1024 * 1024) {
            $errors[] = "File size exceeds the maximum limit (5MB)";
        }
    }
}
if ($visa_free === null) {
    $errors[] = 'Select visa free';
}
if ($direct_flight === null) {
    $errors[] = 'Select direct flight';
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("location: ./");
    exit;
}

$sql = "insert into city" .
" (name, country_id, population_id, continent_id, visa_free, direct_flight,city_img)" .
" values ('" . mysqli_real_escape_string($conn, $name) . "'," .
" $country_id, $population_id, $continent_id," .
" " . ($visa_free === 'y' ? 1 : 0) . "," .
" " . ($direct_flight === 'y' ? 1 : 0) . ",
    '" . mysqli_real_escape_string($conn, file_get_contents($city_img["tmp_name"])) . "'

    )
    ";

mysqli_query($conn, $sql);
var_dump($conn);
die;

$id = mysqli_insert_id($conn);

$id = $conn->insert_id;

file_put_contents("../city-image/$id.jpg", file_get_contents($city_img["tmp_name"]));

header("location: ../");
