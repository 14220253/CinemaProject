<?php

session_start();
//SEMUA PAGE YANG ADA SETELAH SIGN IN PERLU PAKAI INI DIATAS TIAP CODINGAN

require __DIR__ . "/database.php";
// cek cookie
if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])){
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];
    $sql = "SELECT * FROM customer WHERE id = '$id'";
    $result = $mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

    
    if($_COOKIE["key"] == hash("sha256", $row["username"])) {
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $row["username"];
        header("Location: ../signup-in page/index.php");
        exit;
    
    }
}


if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$isInvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // cek apakah tombol login sudah ditekan
    if (isset($_POST["login"])) {

        
        $userName = strtolower(trim($_POST["username"]));
        $password = $_POST["password"];

        $errmsg = "";

        //real_escape_string iki aku delok dr tutoriale ben g isa di sql injection attack kalau gmw lgsg aja pake $_POST["username"]
        $sql = sprintf(
            "SELECT * FROM customer WHERE username = '%s'",
            $mysqli->real_escape_string($userName)
        );

        $result = $mysqli->query($sql);


        // cek jumlah row yang di return
        if (mysqli_num_rows($result) == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                // session_regenerate_id();

                $_SESSION["username"] = $user["username"];
                $_SESSION["login"] = true;

                //cek apakah remember me dicentang
                if (isset($_POST["cookie"])) {
                    setcookie("id", $user["customer_id"], time()+60);
                    setcookie("key", hash("sha256", $user["username"]), time()+60);
                } 

                header("Location: ../signup-in page/index.php");
                exit;
            } else {
                $errmsg = "Wrong Password";
            }
        } else {
            $isInvalid = true;
            $errmsg = "Username Not Found";
        }
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PCinemaU</title>
    <link rel="stylesheet" href="../signup-in page/style.css">
    <link rel="stylesheet" href="../Partials/general.css">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
       
    </style>


    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    </script>
    <?php if (strlen($errmsg) > 0) : ?>
        <script>
            $(document).ready(function() {
                Toast.fire({
                    icon: "error",
                    title: "<?= $errmsg ?>"
                })
            })
        </script>
    <?php endif; ?>



</head>

<body>
    <section>

        <div class="signin">
            <div class="content">
                <h2>Sign in</h2>
                <form method="post" class="form">
                    <div class="inputBox">
                        <input type="text" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required autocomplete="off"> <!--value yang aku tuli ini agar inputannya tidak hilang saat direfresh-->
                        <i>Username</i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" required autocomplete="off">
                        <i>Password</i>
                    </div>
                    <div class="links">
                        <div>
                        <input type="checkbox" name="cookie" id="myCookie">
                        <label for="myCookie" style="color:  rgb(0, 183, 255); padding-left: 10px;">Remember Me</label>
                        
                        </div>
                        
                        <!-- <a href="pcucinemasignuppage.html">Signup</a> -->
                        <a href="signup-page.php">Sign-Up</a> <!--iki nama signup ku-->
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="login" value="Login">
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
    <!-- partial -->
    <script src="../Partials/autoHoverBG.js"></script>

</body>

</html>