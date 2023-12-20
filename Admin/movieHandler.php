<?php
require_once('databaseUAS.php');
class MovieHandler extends Database
{
    function resetSeat()
    {
        $status = 0;
        $sql = "UPDATE `seat` SET `status`=? ;";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("i", $status);
        $prepared->execute();
        $status1 = false;
        try {
            if ($prepared->execute()) {
                return $status1 = true;
            } else {
                throw new Exception($this->conn->error);
            }
        } catch (Exception $e) {
            return $status1 = false;
        } finally {
            return $status1;
            $prepared->close();
        }
    }
    function addMovie($movie_id, $movie_name, $genre, $trailer, $fk_supplier_id, $movie_length, $movie_details, $produser, $sutradara, $penulis, $cast, $movie_image, $status)
    {
        $sql = "INSERT INTO `movie` (`movie_id`, `movie_name`, `genre`, `trailer`, `fk_supplier_id`, `movie_length`, `movie_details`, `produser`, `sutradara`, `penulis`, `cast`, `movie_image`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("isssiissssssi", $movie_id, $movie_name, $genre, $trailer, $fk_supplier_id, $movie_length, $movie_details, $produser, $sutradara, $penulis, $cast, $movie_image, $status);
        $prepared->execute();
        $status = false;

        try {
            if ($prepared->execute()) {
                $status = true;
            } else {
                throw new Exception($prepared->error);
            }
        } catch (Exception $e) {
            $status = false;
        } finally {
            $prepared->close();
            return $status;
        }
    }
    function deleteMovie($movie_id, $movie_name)
    {
        $sql = "DELETE  FROM `movie` WHERE movie_id = ? AND movie_name=?";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("is", $movie_id, $movie_name);
        $prepared->execute();
        $status = false;

        try {
            if ($prepared->execute()) {
                $status = true;
            } else {
                throw new Exception($prepared->error);
            }
        } catch (Exception $e) {
            $status = false;
        } finally {
            $prepared->close();
            return $status;
        }
    }
    function seeTransaction($customer_id)
    {
        $sql = "SELECT name, movie_name, price,kursi_id FROM `tiket` t JOIN `movie`m ON m.movie_id = t.fk_movie_id JOIN `seat` s ON s.kursi_id = t.fk_kursi_id JOIN `schedule_hours` sh ON sh.schedule_hours_id = t.fk_schedule_hours_id JOIN `customer`c ON c.customer_id = t.fk_customer_id WHERE customer_id =?;";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("i", $customer_id);
        $prepared->execute();
        try {
            $status = false;
            if ($prepared->execute()) {
                return $status = true;
            } else {
                throw new Exception($this->conn->error);
            }
        } catch (Exception $e) {
            return $status = false;
        } finally {
            return $status;
            $prepared->close();
        }
    }

    function addTheatre($theatre_name, $phone, $location)
    {
        $sql2 = "select * from location where address = ?";
        $prepared2 = $this->conn->prepare($sql2);
        $prepared2->bind_param("s", $location);
        $prepared2->execute();
        $result = $prepared2->get_result(); // Fetch the result
        $location_id = null;

        if ($result->num_rows == 1) {
            $status2 = true;
            $row = $result->fetch_assoc(); // Fetch the row
            $location_id = $row['location_id']; // Get the location_id from the row
        } else {
            $status2 = false;
            $sql3 = "insert into 'location' ('address') values (?);";
            $prepared3 = $this->conn->prepare($sql3);
            $prepared3->bind_param("s", $location);
            $prepared3->execute();
            //get the location id after insert
            $sql4 = "select * from location where address = ?";
            $prepared4 = $this->conn->prepare($sql4);
            $prepared4->bind_param("s", $location);
            $prepared4->execute();
            $result2 = $prepared4->get_result(); // Fetch the result
            $location_id = null;
            $row = $result2->fetch_assoc(); // Fetch the row
            $location_id = $row['location_id']; // Get the location_id from the row

        }



        $sql = "INSERT INTO `data_theatre` (`theatre_name`, `phone`, `fk_location_id`) VALUES (?,?,?);";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("sis", $theatre_name, $phone, $location_id);
        $status = false;

        try {
            if ($prepared->execute()) {
                $status = true;
            } else {
                throw new Exception($prepared->error);
            }
        } catch (Exception $e) {
            $status = false;
        } finally {
            $prepared->close();
            return $status;
        }
    }


    function addSchedule($movie_id, $theatre_id, $start_date, $end_date, $price, $startT)
    {
        $sql0 = "select * from detail_penayangan where fk_movie_id = ? and fk_theatre_id = ? and start_date = ? and end_date = ? and harga_tiket = ?";
        $prepared2 = $this->conn->prepare($sql0);
        $prepared2->bind_param("iissi", $movie_id, $theatre_id, $start_date, $end_date, $price);
        $prepared2->execute();
        $result = $prepared2->get_result(); // Fetch the result
        // check row
        if ($result->num_rows == 1) {
            $status2 = true;
            $row = $result->fetch_assoc(); // Fetch the row
            $detail_penayangan_id = $row['detail_penayangan_id']; // Get the detail_penayangan_id from the row
        } else {
            $status2 = false;
            $sql = "INSERT INTO detail_penayangan (fk_movie_id, fk_theatre_id, start_date, end_date, harga_tiket) VALUES (?, ?, ?, ?, ?)";
            $prepared = $this->conn->prepare($sql);
            $prepared->bind_param("iissi", $movie_id, $theatre_id, $start_date, $end_date, $price);
            $prepared->execute();

            //select id from detail_penayangan
            $sql2 = "select * from detail_penayangan where fk_movie_id = ? and fk_theatre_id = ? and start_date = ? and end_date = ? and harga_tiket = ?";
            $prepared2 = $this->conn->prepare($sql2);
            $prepared2->bind_param("iissi", $movie_id, $theatre_id, $start_date, $end_date, $price);
            $prepared2->execute();
            $result = $prepared2->get_result(); // Fetch the result
            $detail_penayangan_id = null;
            while ($row = $result->fetch_assoc()) {  // fetch array
                $detail_penayangan_id = $row['detail_penayangan_id']; // Get the detail_penayangan_id from the row
            }
        }


        $sql3 = "INSERT INTO `schedule_hours` (`jam_penayangan`, `fk_detail_penayangan_id`) VALUES (?, ?);";
        $prepared3 = $this->conn->prepare($sql3);
        $prepared3->bind_param("si", $startT, $detail_penayangan_id);
        //return true when success
        $status = true;

        // for ($i = 0; $i < count($startT); $i++) {
            try {
                if (!$prepared3->execute()) {
                    throw new Exception($prepared3->error);
                }
            } catch (Exception $e) {
                $status = false;
                 // Exit the loop if an error occurs
            }
        // }

        $prepared3->close();
        return $status;
    }
}
