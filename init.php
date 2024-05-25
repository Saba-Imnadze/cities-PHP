<?php
session_start();

define('SITE_BASE', '/cities/');

$conn = mysqli_connect("localhost", "root", "", "world");

include_once __DIR__ . '/functions/city_form.php';
include_once __DIR__ . '/functions/city_item.php';
include_once __DIR__ . '/functions/city_list.php';
include_once __DIR__ . '/functions/continent_filter.php';
include_once __DIR__ . '/functions/country_filter.php';
include_once __DIR__ . '/functions/css_files.php';
include_once __DIR__ . '/functions/db_city_list.php';
include_once __DIR__ . '/functions/echo_page.php';
include_once __DIR__ . '/functions/filter.php';
include_once __DIR__ . '/functions/population_filter.php';
include_once __DIR__ . '/functions/request_continent_id.php';
include_once __DIR__ . '/functions/request_country_id.php';
include_once __DIR__ . '/functions/request_direct_flight.php';
include_once __DIR__ . '/functions/request_population_id.php';
include_once __DIR__ . '/functions/request_q.php';
include_once __DIR__ . '/functions/request_string.php';
include_once __DIR__ . '/functions/request_visa_free.php';
include_once __DIR__ . '/functions/show_errors.php';
