<?php
require_once('databaseUAS.php');
class MovieHandler extends Database{
    function resetSeat(){
        $status = 0;
        $sql = "UPDATE `seat` SET `status`=? ;";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("i",$status);
        $prepared->execute();
        $status1= false;
        try{
            if($prepared->execute()){
                return $status1 = true;
            }else{
                throw new Exception($this->conn->error);
            }
        }catch(Exception $e){
            return $status1 = false;
        }finally{
            return $status1;
            $prepared->close();
        }

    }
    function addMovie($movie_id, $movie_name, $genre, $trailer, $fk_supplier_id, $movie_length, $movie_details, $produser, $sutradara, $penulis, $cast, $movie_image, $status){
        $sql = "INSERT INTO `movie` (`movie_id`, `movie_name`, `genre`, `trailer`, `fk_supplier_id`, `movie_length`, `movie_details`, `produser`, `sutradara`, `penulis`, `cast`, `movie_image`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("isssiissssssi", $movie_id, $movie_name, $genre, $trailer, $fk_supplier_id, $movie_length, $movie_details, $produser, $sutradara, $penulis, $cast, $movie_image, $status);
        $prepared-> execute();
        $status = false;

        try {
            if($prepared->execute()){
                $status = true;
            } else {
                throw new Exception($prepared->error);
            }
        } catch(Exception $e) {
            $status = false;
        } finally {
            $prepared->close();
            return $status;
        }
    }
    function deleteMovie($movie_id, $movie_name){
        $sql = "DELETE  FROM `movie` WHERE movie_id = ? AND movie_name=?";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("is", $movie_id, $movie_name);
        $prepared-> execute();
        $status = false;

        try {
            if($prepared->execute()){
                $status = true;
            } else {
                throw new Exception($prepared->error);
            }
        } catch(Exception $e) {
            $status = false;
        } finally {
            $prepared->close();
            return $status;
        }
    }
    function seeTransaction($customer_id){
        $sql = "SELECT name, movie_name, price,kursi_id FROM `tiket` t JOIN `movie`m ON m.movie_id = t.fk_movie_id JOIN `seat` s ON s.kursi_id = t.fk_kursi_id JOIN `schedule_hours` sh ON sh.schedule_hours_id = t.fk_schedule_hours_id JOIN `customer`c ON c.customer_id = t.fk_customer_id WHERE customer_id =?;";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("i", $customer_id);
        $prepared-> execute();
        try{
            $status = false;
            if($prepared->execute()){
                return $status = true;
            }else{
                throw new Exception($this->conn->error);
            }
        }catch(Exception $e){
            return $status = false;
        }finally{
            return $status;
            $prepared->close();
        }
    } 
}
?>