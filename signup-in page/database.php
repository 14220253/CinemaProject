<?php


$host = "localhost";
$dbname = "pcinemau";
$username = "root";
$password = "";

$mysqli = mysqli_connect($host, $username, $password, $dbname);
if ($mysqli->connect_errno) {
    die("Connection error: ".$mysqli->connect_error);
}

function query ($query) {
    global $mysqli;
    $result = mysqli_query($mysqli, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function insertData ($data) {
    $name = $data["name"];
    $address = $data["address"];
    $phone_number = $data["phone_number"];
    $username = $data["username"];
    $password = $data["password"];

    global $mysqli;

    $query = "INSERT INTO user (name, address, phone_number, username, password) VALUES ('$name', '$address', '$phone_number', '$username', '$password')";
    $result = mysqli_query($mysqli, $query);
    if (!$result){

        echo mysqli_error($mysqli);
        return false;
    }
    echo
    "<script>
        alert('user baru berhasil ditambahkan');
        document.location.href = 'signin-page.html'
    </script>";
    return mysqli_affected_rows($mysqli);
}


function getMovie($id) {
    global $mysqli;
    $query = "SELECT * FROM movie WHERE movie_id = $id";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);
    $poster = $row["movie_image"];
    // header("Content-type: image/jpg");
    echo base64_encode($poster);

}


function getTheatre() {
    global $mysqli;
    $query = "SELECT * FROM data_theatre dt LEFT JOIN location l ON fk_location_id = location_id";
    $result = mysqli_query($mysqli, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function availableSeat ($id, $theatre_id) {
    global $mysqli;
    $query = "SELECT * FROM seat WHERE status = 0 AND fk_diagram_kursi_id = $id AND fk_theatre_id = $theatre_id";
    $result = mysqli_query($mysqli, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return count($rows);

}


function getUserID ($username) {
    global $mysqli;
    $query = "SELECT customer_id FROM customer WHERE username = '$username'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["customer_id"];
}



?>