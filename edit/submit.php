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

if (!array_key_exists('id', $_GET)) {
    header('location: ' . SITE_BASE);
    exit;
}

$id = $_GET['id'];

if (!is_string($id)) {
    header("location: " . SITE_BASE);
    exit;
}

$sql = "SELECT * FROM `city` WHERE id = " . (int) $id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row === null) {
    header('location: ' . SITE_BASE);
    exit;
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
        } else {
            $image = @imagecreatefromstring(file_get_contents($city_img['tmp_name']));
            if ($image === false) {
                $errors[] = "Invalid image";
            }
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
    header("location:index.php?id=$row[id]");
    exit;
}

mysqli_real_escape_string($conn, $name);

$sql = "UPDATE `city` SET" .
" name = '" . mysqli_real_escape_string($conn, $name) . "'," .
" country_id = '" . mysqli_real_escape_string($conn, $country_id) . "'," .
" population_id = '" . mysqli_real_escape_string($conn, $population_id) . "'," .
" continent_id = '" . mysqli_real_escape_string($conn, $continent_id) . "'," .
" visa_free = '" . mysqli_real_escape_string($conn, $visa_free) . "'" .
    " WHERE id = " . $row['id'];

mysqli_query($conn, $sql);

//file_put_contents("../city-image/" . $row['id'] . ".jpg", file_get_contents($city_img["tmp_name"]));
imagejpeg($image, "../city-image/" . $row['id'] . ".jpg", 80);

header('location:../index.php');
exit;
