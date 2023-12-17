<?php

require "database.php";

session_start();


if (isset($_POST["user_id"]) && isset($_POST["movie_id"])) {
    $user_id = $_POST["user_id"];
    $movie_id = $_POST["movie_id"];


    $sql = "SELECT * FROM fav_movie WHERE user_id = ? AND movie_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $user_id, $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) { // add to favorite list
        $sql = "INSERT INTO fav_movie (user_id, movie_id) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $user_id, $movie_id);
        $stmt->execute();
        echo "insert";
    } else { // remove from favorite list
        $sql = "DELETE FROM fav_movie WHERE user_id = ? AND movie_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $user_id, $movie_id);
        $stmt->execute();
        echo "delete";
    }
}

?>