<?php
//FILE PHP INI SEBAGAI PLACEHOLDER UNTUK HOMEPAGE
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__."/database.php";

    $sql = "SELECT * FROM customer WHERE customer_id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <h1>HOME PAGE</h1>
    <?php if (isset($user)): ?>
        <p>Hello <?php htmlspecialchars($user["username"])?></p><!--aku bingung kok g isa tampil usernamenya-->

        <p><a href="logout.php">Log out</a></p>
    <?php else: ?>
        <p><a href="signin-page.php">Sign in</a> or <a href="signup-page.php">Sign up</a></p>
    <?php endif; ?>
</body>
</html>