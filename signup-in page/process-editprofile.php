<?php

session_start();
require __DIR__ . "/database.php";


function validatePhoneNumber($phoneNumber) {
    // Remove non-numeric characters from the phone number
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Check if the phone number has a valid length (e.g., 10 digits for a basic validation)
    if (strlen($phoneNumber) >= 10) {
        return true;
    } else {
        return false;
    }
}

function validData($data) {
    return trim(stripslashes(strtolower($data)));

}

$errors = [];
$confirm = false;
$requiredFields = ['username', 'password', 'confirmPassword', 'name', 'address', 'phone_number'];
$errorMessage = [
    'username' => 'Username is required',
    'password' => 'Password is required',
    'confirmPassword' => 'Confirmation password is required',
    'name' => 'Name is required',
    'address' => 'Address is required',
    'phone_number' => 'Phone number is required'
];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $errors[$field] = $errorMessage[$field];
    }
}

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])){
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];
    $sql = "SELECT * FROM customer WHERE id = '$id'";
    $result = $mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

    
    if($_COOKIE["key"] != $_POST["password"]) {
        $errors['password'] = "Passwords don't match";
    }
}

// if (!password_verify($_POST["password"], $user["password"])) {
//     $errors['password'] = "Passwords don't match";
// }

if (!validatePhoneNumber($_POST["phone_number"]) && !empty($_POST["phone_number"])) {
    $errors['phone_number'] = "Invalid phone number";
}

if (empty($errors)) {
    require __DIR__."/database.php";
    $name = validData($_POST["name"]);
    $address = validData($_POST["address"]);
    $phone_number = validData($_POST["phone_number"]);
    $username = validData($_POST["username"]);
    $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT); // encrypsi
    $sql = "INSERT INTO customer(name, address, phone_number, username, password) VALUES (?, ?, ?, ?, ?)";
    // Continue with the rest of your code
    $stmt = $mysqli->stmt_init();

    try {
        if (!$stmt->prepare($sql)) {
            throw new Exception("SQL preparation failed: ".$mysqli->error);
        }
    } catch (Exception $e) {
        die("SQL error: ".$mysqli->error);
    }

    $stmt->bind_param("sssss", $name, $address, $phone_number, $username, $password);

    try {
        if($stmt->execute())  {

            // header("Location: signup-success.html");
            $confirm = true;
            // echo 
            // '<script>
            // Swal.fire({
                // icon: "success",
                // title: "success",
                // html: "<h1>Data inserted successfully!</h1>",
                // footer: "<a href="#">Login Now</a>"
            // });
            // </script>';
            
        }
    } catch(Exception $e) {
        if ($mysqli->errno === 1062)
            $errors["username"] = "username already taken";
        else
            die ($mysqli->error." ".$mysqli->errno);
    }


}




?>