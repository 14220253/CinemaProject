<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PCinemaU</title>
  <link rel="stylesheet" href="./style.css">
  
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap" rel="stylesheet">
  

<style>
  /* Custom styles for the alert */
  .custom-swal {
    background: rgb(251,246,63);
background: radial-gradient(circle, rgba(251,246,63,1) 0%, rgba(252,70,107,1) 100%); /* Set the background color */
      color: #333; /* Set the text color */
      border-radius: 8px; /* Set border-radius for rounded corners */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add a subtle box shadow */
      font-weight: bolder;
      text-decoration: none;
  }
</style>
<?php

session_start();
//cek apakah tombol submit sudah ditekan
  if(isset($_POST['register'])) {
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
<?php if (isset($errors['name'])): ?>
  <script>
    $(document).ready(function() {
      Toast.fire({
        icon: 'error',
        title: '<?php echo $errors['name']; ?>!'
      })
    })
  </script>
  <?php elseif (isset($errors['address'])): ?>
    <script>
      $(document).ready(function() {
      })
      Toast.fire({
        icon: 'error',
        title: '<?php echo $errors['address']; ?>!'
      })
    </script>
  <?php elseif (isset($errors['phone_number'])): ?>
    <script>
    $(document).ready(function() {
      Toast.fire({
        icon: 'error',
        title: '<?php echo $errors['phone_number']; ?>!',
      })
    })
    </script>

<?php elseif (isset($errors['username'])): ?>
  <script>
  $(document).ready(function() {
    Toast.fire({
      icon: 'error',
      title: '<?php echo $errors['username']; ?>!',
    })
  })
  </script>   
<?php elseif (isset($errors['password'])): ?>
  <script>
  $(document).ready(function() {
    Toast.fire({
      icon: 'error',
      title: '<?php echo $errors['password']; ?>!',
    })
  })
  </script>
<?php elseif (isset($errors['confirmPassword'])): ?> 
  <script>
  $(document).ready(function() {
    Toast.fire({
      icon: 'error',
      title: '<?php echo $errors['confirmPassword']; ?>!',
    })
  })  
  </script>
  <?php elseif ($confirm): $_SESSION['confirm'] = false;?> 
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
  foreach($errors as $err) {
    $err = "";
  }
  
  ?>

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
    margin-top: 20px;
    margin-bottom: 20px;
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
    <?php for ($i = 0; $i < 350; $i++) : ?>
      <span></span> <!--ini dibuat kotak kotak e-->
    <?php endfor; ?>
    <div class="signin">
      <div class="content">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="form">
          <div class="inputBox">
            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($form_data["name"] ?? '')?>">
            <i>Name</i>
           
          </div>
          <div class="inputBox">
            <input type="text" id="address" name="address" required value="<?php echo htmlspecialchars($form_data["address"] ?? '')?>">
            <i>Address</i>
            
          </div>
          <div class="inputBox">
            <input type="text" id="phone_number" name="phone_number" required value="<?php echo htmlspecialchars($form_data["phone_number"]?? '')?>">
            <i>Phone Number</i>
            
          </div>
          <div class="inputBox">
            <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($form_data["username"] ?? '')?>">
            <i>Username</i>
            
          </div>
          <div class="inputBox">
            <input id="password" type="password" name="password" required value="<?php echo htmlspecialchars($form_data["password"]?? '')?>">
            <i>Password</i>
            
          </div>
          <div class="inputBox">
            <input id="confirmPassword" type="password" name="confirmPassword" required value="<?php echo htmlspecialchars($form_data["confirmPassword"] ?? '')?>">
            <i>Confirm Password</i>
           
          </div>
          <div class="links">
            <!-- <a href="pcucinemasiginpage.html">Sign in</a> -->
            <a href="signin-page.php">Sign in</a> <!--ini signin pageku-->
          </div>
          <div class="warning" style="display:none; color:red">
          </div>
          <div class="inputBox">
            <!-- <button>Confirm</button> -->
            <input class = "submitButton" type="submit" name="register" value="Confirm">
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- partial -->

</body>

</html>





