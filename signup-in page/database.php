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



return $mysqli;

?>