<?php

function show_errors()
{
    $html = '';
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        $html .= "<div class='Errors'>";
        foreach ($errors as $error) {

            $html .= "<div>" . htmlspecialchars($error) . "</div>";

        }
        $html .= "</div>";

        unset($_SESSION['errors']);
    }
    return $html;
}
