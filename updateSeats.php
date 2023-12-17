<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedSeats = $_POST['selectedSeats'];

 
    try {
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pcinemau";

        $mysqli = new mysqli($host, $username, $password, $dbname);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $placeholders = implode(',', array_fill(0, count($selectedSeats), '?'));
        $stmt = $mysqli->prepare("UPDATE seat SET status = 1 WHERE kursi_id IN ($placeholders)");

        $types = str_repeat('s', count($selectedSeats));
        $stmt->bind_param($types, ...$selectedSeats);


        $stmt->execute();

        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();

        $mysqli->close();
        ob_clean();

        echo json_encode(['status' => 'success', 'message' => 'Seats updated successfully']);
    } catch (Exception $e) {

        echo json_encode(['status' => 'error', 'message' => 'Error updating seats: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}



?>
