<?php

include_once "../init.php";

$body = '<div class="main_container">' .
'<h1>Add City</h1>' .
"<a href='" . SITE_BASE . "'>Back</a>" .
'<div class="inner_container">' .
city_form($conn, 'submit.php', '', null, null, null, null, null) .
    '</div>';

echo_page([
    'body' => $body,
    'title' => "Add City",
]);
