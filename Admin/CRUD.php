<?php

$host = "localhost";
$username = "";
$pass = "";
$dbname = "";

$conn = mysqli_connect();

function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function delete($data) {
    global $conn;
    $id = $data["id"];
    $query = "DELETE FROM customer WHERE customer_id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function insertCustomer($data) {
    global $conn;
    $name = $data["name"];
    $address = $data["address"];
    $phone_number = $data["phone_number"];
    $username = $data["username"];
    $password = $data["password"];

    $query = "INSERT INTO user (name, address, phone_number, username, password) VALUES ('$name', '$address', '$phone_number', '$username', '$password')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function insertFilm ($data) {
    global $conn;
    $movie_name = $data["title"];
    $genre = $data["genre"];
    $duration = $data["duration"];
    $supplier = $data["supplier"];
    $description = $data["description"];
    $poster = $data["poster"];

    $query = "INSERT INTO film (movie_name, genre, movie_length, fk_supplier_id, movie_details, poster) VALUES ('$movie_name', '$genre', '$duration', '$supplier', '$description', '$poster')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteFilm($data) {
    global $conn;
    $id = $data["id"];
    $query = "DELETE FROM film WHERE movie_id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
?>