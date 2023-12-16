<?php
session_start();
$errors = [];
$confirm = false;
$requiredFields = ['password'];
$errorMessage = [
    'password' => 'Password is required',
];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $errors[$field] = $errorMessage[$field];
    }
}

if (!password_verify($_POST["password"], $_SESSION["pass"])) {
    $errors['password'] = "Wrong Password";
}
if (empty($errors)) {
    $username = $_SESSION["username"];
    $sql = "DELETE FROM customer WHERE username = '$username'";

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