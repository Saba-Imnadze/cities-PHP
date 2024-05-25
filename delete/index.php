<?php
include_once "../init.php";
if (!array_key_exists('id', $_GET)) {
    header('location:../index.php');
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM `city` WHERE id=" . (int) $id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row === null) {
    header('location:../index.php');
    exit;
}

echo_page([
    'body' => '<div class="delete_container">' .

    '<h1>' . htmlspecialchars($row['name']) . '</h1>' .
    '<div class="delete_container">' .

    "<p class='delete_question'>Are you sure you want to delete this City?</p>" .
    "<form class='delete_form' method='post' action='submit.php?id=$id'>" .
    "<div class='deleteBtn_container'>" .
    "<button type='submit'class='delete_confirm'>Yes, Delete</button>" .
    "<a href='../index.php'class='delete_cancel'>Cancel</a>" .
    "</div>" .

    "</form>" .
    '</div>',
    'title' => $row['name'],
]);
