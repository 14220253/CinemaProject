<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PCinemaU</title>

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
    require "process-signup.php";
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

<link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"
        ></script>
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
  <?php if (isset($errors['name'])) : ?>
    <script>
      $(document).ready(function() {
        Toast.fire({
          icon: 'error',
          title: '<?php echo $errors['name']; ?>!'
        })
      })
    </script>
  <?php elseif (isset($errors['address'])) : ?>
    <script>
      $(document).ready(function() {})
      Toast.fire({
        icon: 'error',
        title: '<?php echo $errors['address']; ?>!'
      })
    </script>
  <?php elseif (isset($errors['phone_number'])) : ?>
    <script>
      $(document).ready(function() {
        Toast.fire({
          icon: 'error',
          title: '<?php echo $errors['phone_number']; ?>!',
        })
      })
    </script>

  <?php elseif (isset($errors['username'])) : ?>
    <script>
      $(document).ready(function() {
        Toast.fire({
          icon: 'error',
          title: '<?php echo $errors['username']; ?>!',
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
        <h3 style="color:  white;">Are you sure you want to delete your account?</h3>
        <a type="button" class="btn btn-secondary w-75" href="profile-page.php"><b>Go back</b></a>
        <a type="button" class="btn btn-warning w-75" href="confirmdeleteaccount-page.php"><b>Proceed</b></a>
      </div>
    </div>
  </section>


  <!-- partial -->
  <script src="../Partials/autoHoverBG.js"></script>
</body>

</html>