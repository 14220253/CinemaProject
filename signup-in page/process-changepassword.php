<?php
session_start();
$errors = [];
$confirm = false;
$requiredFields = ['oldPassword', 'password', 'confirmPassword'];
$errorMessage = [
    'oldPassword' => 'Old Password is required',
    'password' => 'Password is required',
    'confirmPassword' => 'Confirm Password is required'
];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $errors[$field] = $errorMessage[$field];
    }
}

if (!password_verify($_POST["oldPassword"], $_SESSION["pass"])) {
    $errors['oldPassword'] = "Wrong Password";
}

if (strlen($_POST["password"]) < 8) {
    $errors['password'] = "Password must be at least 8 characters";
}

if ($_POST["password"] !== $_POST["confirmPassword"]) {
    $errors['confirmPassword'] = "Passwords must match";
}

if (empty($errors)) {
    $username = $_SESSION["username"];
    $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT); // encrypsi
    $sql = "UPDATE customer SET password = '$password' WHERE username = '$username'";

    try {
        if ($mysqli->query($sql)) {
            session_destroy();
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