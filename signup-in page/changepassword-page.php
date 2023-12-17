<?php
session_start();
require __DIR__ . "/database.php";
$guessUser = false;
if (isset($_SESSION["login"])) {
    
    $data = $_SESSION["username"];

    $sql = "SELECT * FROM customer WHERE username = '$data'";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    
    $guessUser = false;

    $_SESSION["pass"] = $user["password"];
} else {
    $guessUser = true;
    header("Location: /signup-in page/signin-page.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PCinemaU</title>
  <link rel="icon" type="image/png" href="../Partials/favIcon.png">

  <!-- background -->
  
  <link rel="stylesheet" href="../signup-in page/style.css">
  <link rel="stylesheet" href="../Partials/general.css">
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap" rel="stylesheet">


  <style>
    /* Custom styles for the alert */
    .custom-swal {
      background: rgb(251, 246, 63);
      background: radial-gradient(circle, rgba(251, 246, 63, 1) 0%, rgba(252, 70, 107, 1) 100%);
      /* Set the background color */
      color: #333;
      /* Set the text color */
      border-radius: 8px;
      /* Set border-radius for rounded corners */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      /* Add a subtle box shadow */
      font-weight: bolder;
      text-decoration: none;
    }
  </style>
  <?php

  session_start();
  //cek apakah tombol submit sudah ditekan
  if (isset($_POST['register'])) {
    //  cek apakah valid
    require "process-changepassword.php";
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    $_SESSION['confirm'] = $confirm;

    // Prevent form resubmission
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
  }
  // Retrieve the error messages and form data from the session
  $errors = $_SESSION['errors'] ?? [];
  $form_data = $_SESSION['form_data'] ?? [];
  $confirm = $_SESSION['confirm'] ?? false;

  // Clear the form data and error messages from the session
  unset($_SESSION['form_data'], $_SESSION['errors']);
  ?>


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
  <?php if (isset($errors['oldPassword'])) : ?>
    <script>
      $(document).ready(function() {
        Toast.fire({
          icon: 'error',
          title: '<?php echo $errors['oldPassword']; ?>!',
        })
      })
    </script>
  <?php elseif (isset($errors['password'])) : ?>
    <script>
      $(document).ready(function() {
        Toast.fire({
          icon: 'error',
          title: '<?php echo $errors['password']; ?>!',
        })
      })
    </script>
  <?php elseif (isset($errors['confirmPassword'])) : ?>
    <script>
      $(document).ready(function() {
        Toast.fire({
          icon: 'error',
          title: '<?php echo $errors['confirmPassword']; ?>!',
        })
      })
    </script>
  <?php elseif ($confirm) : $_SESSION['confirm'] = false; ?>
    <script>
      $(document).ready(function() {
        Swal.fire({
          icon: "success",
          html: `<h1 style="font-family: 'Vina Sans', sans-serif; font-size:4em">SUCCESS!</h1>`,
          footer: "<b><a style='font-size:1.2em; font-style:' href='signin-page.php'>Sign-In Now</a></b>",
          showClass: {
            popup: `
            animate__animated
            animate__fadeInUp
            animate__faster
          `
          },
          hideClass: {
            popup: `
            animate__animated
            animate__fadeOutDown
            animate__faster
          `
          },
          customClass: {
            popup: 'custom-swal' // Apply the custom class
          }
        })
      })
    </script>
  <?php endif;
  foreach ($errors as $err) {
    $err = "";
  }

  ?>

</head>

<body>
  <section>
    
    <div class="signin">
      <div class="content">
        <h2>CHANGE PASSWORD</h2>
        <div class="row"></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="form">
          <div class="inputBox">
            <input type="password" id="oldPassword" name="oldPassword" required value="<?php echo htmlspecialchars($form_data["oldPassword"] ?? '') ?>">
            <i>Old Password</i>

          </div>
          <div class="inputBox">
            <input id="password" type="password" name="password" required value="<?php echo htmlspecialchars($form_data["password"] ?? '') ?>">
            <i>New Password</i>

          </div>
          <div class="inputBox">
            <input id="confirmPassword" type="password" name="confirmPassword" required value="<?php echo htmlspecialchars($form_data["confirmPassword"] ?? '') ?>">
            <i>Confirm Password</i>

          </div>
        <div class="row"></div>
          <div class="warning" style="display:none; color:red">
          </div>
          <div class="inputBox">
            <!-- <button>Confirm</button> -->
            <input class="submitButton" type="submit" name="register" value="Confirm">
          </div>
        </form>
      </div>
    </div>
  </section>


  <!-- partial -->
  <script src="../Partials/autoHoverBG.js"></script>
</body>

</html>