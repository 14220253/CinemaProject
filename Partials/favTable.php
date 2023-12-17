<?php
if (isset($_GET["uid"]) && isset($_GET["mid"])) {
    $user_id = $_GET["uid"];
    $movie_id = $_GET["mid"];


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