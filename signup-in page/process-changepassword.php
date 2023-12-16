<?php
session_start();

function validData($data) {
    return trim(stripslashes(strtolower($data)));
}

$errors = [];
$confirm = false;
$requiredFields = ['password', 'oldpassword', 'confirmpassword'];
$errorMessage = [
    'oldpassword' => 'Old Password is required',
    'password' => 'Password is required',
    'confirmpassword' => 'Confirm Password is required'
]
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $errors[$field] = $errorMessage[$field];
    }
}

if (password_verify($_POST["password"], $_SESSION["pass"])) {
    $errors['password'] = "Password doesn't match";
}

if (empty($errors)) {
    $name = validData($_POST["name"]);
    $address = validData($_POST["address"]);
    $phone_number = validData($_POST["phone_number"]);
    $username = validData($_POST["username"]);
    $sql = "UPDATE customer SET username = '$name', address = '$address', phone_number = '$phone_number', name = '$name' WHERE username = '" . $user["username"] . "'";

    try {
        if ($mysqli->query($sql)) {
            header("Location: /profile-page.php");
            // Rest of your code
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
    } catch (Exception $e) {
        die("SQL error: " . $mysqli->error);
    }


}




?>