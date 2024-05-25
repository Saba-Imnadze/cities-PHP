<?php
include_once "../init.php";

if (!array_key_exists('id', $_GET)) {
    header('location:../index.php');
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM `city` WHERE id =" . (int) $id;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row === null) {
    header('location:../index.php');
    exit;
}
$sql = "DELETE FROM `city` WHERE id=" . (int) $id;
mysqli_query($conn, $sql);
header("location:../index.php");
