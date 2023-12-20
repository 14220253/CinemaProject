<?php
session_start();
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
$requiredFields = ['username', 'password', 'name', 'address', 'phone_number'];
$errorMessage = [
    'username' => 'Username is required',
    'password' => 'Password is required',
    'name' => 'Name is required',
    'address' => 'Address is required',
    'phone_number' => 'Phone number is required'
];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $errors[$field] = $errorMessage[$field];
    }
}

if (!password_verify($_POST["password"], $_SESSION["pass"])) {
    $errors['password'] = "Wrong Password";
}

if (!validatePhoneNumber($_POST["phone_number"]) && !empty($_POST["phone_number"])) {
    $errors['phone_number'] = "Invalid phone number";
}

if (empty($errors)) {
    $orusername = $_SESSION["username"];
    $name = validData($_POST["name"]);
    $address = validData($_POST["address"]);
    $phone_number = validData($_POST["phone_number"]);
    $username = validData($_POST["username"]);
    $sql = "UPDATE customer SET username = '$username', address = '$address', phone_number = '$phone_number', name = '$name' WHERE username = '$orusername'";

    try {
        if ($mysqli->query($sql)) {
            session_destroy();
            header("Location: profile-page.php");
            // Rest of your code
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
    } catch (Exception $e) {
        if ($mysqli->errno === 1062)
            $errors["username"] = "username already taken";
        else
            die ($mysqli->error." ".$mysqli->errno);
        // die("SQL error: " . $mysqli->error);
        header("Location: profile-page.php");
    }


}




?>