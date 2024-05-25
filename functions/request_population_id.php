<?php

function request_population_id($conn)
{
    if (array_key_exists('population_id', $_GET)) {
        $population_id = $_GET['population_id'];
        if (is_string($population_id)) {
            $population_id = (int) $population_id;
            $population_id = abs($population_id);
            $sql = "select * from population where id = $population_id";
            $result = mysqli_query($conn, $sql);
            $population = mysqli_fetch_assoc($result);
            if ($population === null) {
                $population_id = 0;
            }
        } else {
            $population_id = 0;
        }
    } else {
        $population_id = 0;
    }
    return $population_id;
}
