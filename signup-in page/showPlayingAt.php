<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "pcinemau";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


if (isset($_GET['id']) and $_GET['theatre_id']) {
    $movie_id = $_GET['id'];
    $theatre_id = $_GET['theatre_id'];
    $sql = "SELECT theatre_name, jam_penayangan, harga_tiket FROM detail_penayangan ds JOIN movie m ON (m.movie_id= ds.fk_movie_id) JOIN data_theatre t ON (t.theatre_id = ds.fk_theatre_id) JOIN schedule_hours s ON (ds.detail_penayangan_id = s.fk_detail_penayangan_id) WHERE fk_movie_id = ?";
    $prepared = $conn->prepare($sql);
    $prepared->bind_param("i", $movie_id);
    if ($prepared === false) {
        throw new Exception($conn->error);
    }

    $prepared->execute();
    $result = $prepared->get_result();
    // $row = $result->fetch_assoc();

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    $theatre = [];
    foreach ($rows as $row) {
        $theatre[] = $row["theatre_name"];
    }

    $theatre = array_unique($theatre);



    if ($result->num_rows > 0) {
        echo "<thead class='table-dark'>
                <tr>
                    <th><p class='m-2'>Theatre</p></th>
                    <th><p class='m-2'>Show Time</p></th>
                </tr>
            </thead>
            <tbody>";
        foreach ($theatre as $t) {
            echo "<tr>";
            echo "<td> <p class='theatre m-2'>" . $t . "</p></td>";
            echo "<td>";
            foreach ($rows as $row) {
                if ($row["theatre_name"] == $t) {
                    echo "<button type='button' class='btn btn-outline-warning hours m-2' style='min-width: 80px;' value=" . $row['jam_penayangan'] . ">" . $row['jam_penayangan'] . "</button>";
                }
            }
            echo "</td>";
            echo "</tr>";
        }

        
    } else {
        echo "<thead class='table-dark'>
                <tr>
                    <th>Theatre</th>
                    <th>Show Time</th>
                </tr>
            </thead>";
        echo "<tbody>
        <tr>
        <td colspan=2>
        <h1 class='text-danger text-center text-uppercase'>No results found</h1> 
        </td></tr></tbody>";
    }
}
