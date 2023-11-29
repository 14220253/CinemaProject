<?php

if (empty($_POST["username"])) {
    die("username is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be atleast 8 characters");
}

if ($_POST["password"] !== $_POST["confirmPassword"]) {
    die("Password must match");
}

$mysqli = require __DIR__."/database.php";

$sql = "INSERT INTO customer(username, password) VALUES (?, ?)";

$stmt = $mysqli->stmt_init();

try {
    if (!$stmt->prepare($sql));
} catch (Exception $e) {
    die("SQL error: ".$mysqli->error);
}

$stmt->bind_param("ss", $_POST["username"], $_POST["password"]);

try {
    if($stmt->execute())  {
        header("Location: signup-success.html");
        exit;
    }
} catch(Exception $e) {
    if ($mysqli->errno === 1062)
        die("username already taken");
    else
        die ($mysqli->error." ".$mysqli->errno);
}