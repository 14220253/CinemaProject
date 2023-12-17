<?php
require_once('databaseUAS.php');
$database = new Database();
$conn = $database->conn;
if (isset($_GET['q'])) {
    $customer_id = $_GET['q'];

    $query = "SELECT name, movie_name, price,kursi_id, date FROM `tiket` t JOIN `movie`m ON m.movie_id = t.fk_movie_id JOIN `seat` s ON s.kursi_id = t.fk_kursi_id JOIN `schedule_hours` sh ON sh.schedule_hours_id = t.fk_schedule_hours_id JOIN `customer`c ON c.customer_id = t.fk_customer_id WHERE customer_id =?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>
                <thead class='table-warning'>
                    <tr>
                        <th>Date</th>
                        <th>Nama Customer</th>
                        <th>Movie Name</th>
                        <th>Kursi</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" .$row['name']. "</td>";
            echo "<td>" . $row['movie_name'] . "</td>";
            echo "<td>" . $row['kursi_id'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No results found";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
