<?php
require_once('databaseUAS.php');
class AdminHandler extends Database {
    function editAdmin($old_password, $new_password, $nama, $NIP, $kontak) {
        // Select the hashed password from the database
        $sql_select = "SELECT `password` FROM `admin_data` WHERE `NIP` = ?";
        $stmt_select = $this->conn->prepare($sql_select);
        
        if (!$stmt_select) {
            echo "SQL Select Prepare Error: " . $this->conn->error;
            return false;
        }
    
        $stmt_select->bind_param("i", $NIP);
        $stmt_select->execute();
    
        $result = $stmt_select->get_result();
    
        if (!$result) {
            echo "SQL Select Execute Error: " . $stmt_select->error;
            $stmt_select->close();
            return false;
        }
    
        $row = $result->fetch_assoc();
        $hashedPasswordFromDB = $row['password'];
    
        $stmt_select->close();
    
        // Verify old password
        if (!password_verify($old_password, $hashedPasswordFromDB)) {
            return false;
        }
    
        // Hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
        // Update admin data in the database
        $sql_update = "UPDATE `admin_data` SET `nama`=?, `password`=?, `kontak`=? WHERE `NIP`=?";
        $stmt_update = $this->conn->prepare($sql_update);
    
        if (!$stmt_update) {
            echo "SQL Update Prepare Error: " . $this->conn->error;
            return false;
        }
    
        $stmt_update->bind_param("sssi", $nama, $new_hashed_password, $kontak, $NIP);
    
        // Execute the update query
        if ($stmt_update->execute()) {
            $stmt_update->close();
            return true;
        } else {
            echo "SQL Update Execute Error: " . $stmt_update->error;
            $stmt_update->close();
            return false;
        }
    }
    
    
    
    
    
    function addAdmin($NIP, $password, $nama, $kontak, $fk_location_id){
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO `admin_data` (`NIP`, `password`, `nama`, `kontak`, `fk_location_id`) VALUES (?, ?, ?, ?, ?)";
        $prepared = $this->conn->prepare($sql);
        $prepared->bind_param("sssss", $NIP, $hashedPassword, $nama, $kontak, $fk_location_id);
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
    
}
?>