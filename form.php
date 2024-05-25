<?php
include_once "init.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Picture</title>
</head>
<body>
    <h2>Upload Picture</h2>
    <form action="upload_form.php" method="post" enctype="multipart/form-data">
        <label for="picture">Select Picture:</label><br>
        <input type="file" id="picture" name="picture" accept="image/*"><br><br>
        <input type="submit" value="Upload Picture">
    </form>
</body>
</html>
