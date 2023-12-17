<?php

require_once('databaseUAS.php');

class LoginHandler extends Database {
    public function loginUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admin_data WHERE NIP = ?");
        $stmt->bind_param("i", $username);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
    
            $hashedPasswordFromDB = $user['password'];
    
            if (password_verify($password, $hashedPasswordFromDB)) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
}

?>
