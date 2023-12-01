<?php

$isInvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $mysqli = require __DIR__."/database.php";
  //real_escape_string iki aku delok dr tutoriale ben g isa di sql injection attack kalau gmw lgsg aja pake $_POST["username"]
  $sql = sprintf("SELECT * FROM customer WHERE username = '%s'", 
                  $mysqli->real_escape_string($_POST["username"]));

  $result = $mysqli->query($sql);

  $user = $result->fetch_assoc();

  if ($user) {
    if ($_POST["password"] === $user["password"]) {
      session_start();//SEMUA PAGE YANG ADA SETELAH SIGN IN PERLU PAKAI INI DIATAS TIAP CODINGAN
      
      session_regenerate_id();

      $_SESSION["user_id"] = $user["customer_id"];

      header("Location: index.php");
      exit;
    }
  }

  $isInvalid = true;
}


?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>PCinemaU</title>
  <link rel="stylesheet" href="style.css">
  <style>
    section .signin {
    position: absolute;
    width: 400px;
    background: #222;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    border-radius: 4px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 9);
}

section .signin .content {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 40px;
}

section .signin .content h2 {
    font-size: 2em;
    color: rgb(0, 170, 255);
    text-transform: uppercase;
}

section .signin .content .form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

section .signin .content .form .inputBox {
    position: relative;
    width: 100%;
}

section .signin .content .form .inputBox input {
    position: relative;
    width: 100%;
    background: #333;
    border: none;
    outline: none;
    padding: 25px 10px 7.5px;
    border-radius: 4px;
    color: #fff;
    font-weight: 500;
    font-size: 1em;
}

section .signin .content .form .inputBox i {
    position: absolute;
    left: 0;
    padding: 15px 10px;
    font-style: normal;
    color: #aaa;
    transition: 0.5s;
    pointer-events: none;
    /*placeholder*/
}

.signin .content .form .inputBox input:focus~i,
.signin .content .form .inputBox input:valid~i {
    transform: translateY(-7.5px);
    font-size: 0.8em;
    color: #fff;
}

/*kalau lagi fokus maka tulisan di naikkan 7.5px ke atas dan warna nya jadi putih*/
.signin .content .form .links {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: space-between;
}

.signin .content .form .links a {
    color: #fff;
    text-decoration: none;
}

/*forgot password*/
.signin .content .form .links a:nth-child(2) {
    color: rgb(0, 183, 255);
    font-weight: 600;
}

/*signup*/
.signin .content .form .inputBox input[type="submit"] {
    padding: 10px;
    background: rgb(0, 208, 255);
    color: #000;
    font-weight: 600;
    font-size: 1.35em;
    letter-spacing: 0.05em;
    cursor: pointer;
}

/*button*/
input[type="submit"]:hover {
    opacity: 0.75;
}

input[type="submit"]:active {
    opacity: 0.6;
}

/*button on click*/
@media (max-width: 900px) {
    section span {
        width: calc(10vw - 2px);
        height: calc(10vw - 2px);
    }
}

@media (max-width: 600px) {
    section span {
        width: calc(20vw - 2px);
        height: calc(20vw - 2px);
    }
}

/*responsiveness*/

  </style>
</head>

<body>
<section>
    
    <?php for ($i = 0; $i < 350 ; $i++):?>
    <span></span> <!--ini dibuat kotak kotak e-->
    <?php endfor;?>
    
    <div class="signin">
        <div class="content">
          <h2>Sign in</h2>
          <form method="post" class="form">
            <div class="inputBox">
                <input type="text" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "")?>" required autocomplete="off"> <!--value yang aku tuli ini agar inputannya tidak hilang saat direfresh-->
                <i>Username</i>
            </div>
            <div class="inputBox">
                <input type="password" name="password" required autocomplete="off">
                <i>Password</i>
            </div>
            <?php if ($isInvalid): ?>
              <em style="color: cyan;">Invalid login</em> <!--SILAHKAN PAKAI STYLE SENDIRI-->
            <?php endif; ?>  
            <div class="links">
                <a href="#">Forgot Password</a>
                <!-- <a href="pcucinemasignuppage.html">Signup</a> -->
                <a href="signup-page.php">Sign-Up</a> <!--iki nama signup ku-->
            </div>
            <div class="inputBox">
                <input type="submit" value="Login">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<!-- partial -->
  
</body>
</html>