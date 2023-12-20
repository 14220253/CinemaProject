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
    $sql = "SELECT DISTINCT theatre_name, jam_penayangan, harga_tiket, start_date, end_date FROM detail_penayangan ds JOIN movie m ON (m.movie_id= ds.fk_movie_id) JOIN data_theatre t ON (t.theatre_id = ds.fk_theatre_id) JOIN schedule_hours s ON (ds.detail_penayangan_id = s.fk_detail_penayangan_id) WHERE fk_movie_id = ?";
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

    $date = [];





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
            echo "<td> <p class='theatre m-2' rowspan>" . $t . "</p></td>";
            echo "<td >";
            echo "<div style='overflow-y: auto;
            height: 100px;'>";

            echo "<table class='table-hover table table-dark table-stripped h-100 table-responsive'>";

            $checkDate = new DateTime("0000-00-00");
            foreach ($rows as $row) {
                if ($row["theatre_name"] == $t) {
                    $start_date = new DateTime($row["start_date"]);
                    $end_date = new DateTime($row["end_date"]);
                    $current_date = clone $start_date;
                    
                    if ($checkDate != $current_date) {
                        $checkDate = clone $start_date;
                        while ($current_date <= $end_date) {
                            echo "<tr>
                    <th class='w-25'><p class='m-2 dateFilm'>" . $current_date->format('d-m-Y') . "</p></th> 
                    <td>";
                            foreach ($rows as $row) {
                                if ($row["theatre_name"] == $t && new DateTime($row["start_date"]) == $checkDate) {
                                    echo "<button type='button' class='btn btn-outline-warning hours m-2' style='min-width: 80px;' value=" . $row['jam_penayangan'] . ">" . $row['jam_penayangan'] . "</button>";
                                }
                            }
                            echo "</td></tr>";
    
                            $current_date->modify('+1 day');
                        }
                    }
                    
                    // break;
                }
            }


            echo "</table>";
            echo "</div>";
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
