<?php


session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "pcinemau";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $username = $_POST['NIP'];
    $password = $_POST['password'];

    if (!(empty($username) && empty($password))) {
        $stmt = $conn->prepare("SELECT * FROM admin_data WHERE NIP = ?");
        $stmt->bind_param("i", $username);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $hashedPasswordFromDB = $user['password'];

            if (password_verify($password, $hashedPasswordFromDB)) {
                $_SESSION['user'] = $user['nama'];
                header('location: adminConfigurationPage.php');
                exit(); // Important to exit after header redirect
            } else {
                echo '<script>alert("Invalid username or password");</script>';
            }
        } else {
            echo '<script>alert("Invalid username or password");</script>';
        }
    } else {
        echo '<script>alert("Username and password are required");</script>';
    }
}

if (isset($_SESSION['user'])) {
    header('location: adminConfigurationPage.php');
    exit(); // Important to exit after header redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap">
    <script>
        $(document).ready(function(){
            $('#toggleEyeButton').click(function(){
                if ($('#passwordField').attr('type') === 'password') {
                    $('#passwordField').attr('type', 'text');
                    $('#togglePassword').removeClass('bi-eye-slash');
                    $('#togglePassword').addClass('bi-eye');
                } else {
                    $('#passwordField').attr('type', 'password');
                    $('#togglePassword').removeClass('bi-eye');
                    $('#togglePassword').addClass('bi-eye-slash');
                }
            });
            
        });
    </script>
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }
        body {
            background-size: 60px 60px;
            background-color:rgb(14, 13, 13);
            background-image: 
            linear-gradient(to right, rgb(231, 179, 46) 2px, transparent 2px), 
            linear-gradient(to bottom, rgb(231, 179, 46) 2px, transparent 2px);
            animation: backgroundAnimation 2s infinite linear;
        }
        @keyframes backgroundAnimation {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 60px 60px;
        }
}

    </style>
</head>
<body>
    <div class="d-flex align-content-center justify-content-center" style="padding-top: 50px;">
        <div class="card bg-dark text-center text-warning">
            <div class="card-content">
                <div class="card-header opacity">
                    <div class="card-title">
                        <h1><strong>ADMIN LOGIN.</strong></h1>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="usernameIcon"><strong style="font-size:18px;">@</strong></span>
                        <input name ="NIP" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="usernameIcon">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="passwordIcon"><i class="bi bi-lock-fill"></i></span>
                        <input name = "password" id="passwordField" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="passwordIcon">
                        <span class="input-group-text"><button id="toggleEyeButton" style="border-style:none;"><i class="bi bi-eye-slash" id="togglePassword"></i></button></span>
                    </div>
                    <div>
                        <p>Forgot Password ?</p>
                        <p>Contact your supervisor</p>
                      
                    </div>
                  </div>
                <div class="card-footer">
                    <button class="btn btn-dark text-warning border border-warning" type="submit" name='submit'>LOG IN</button>
                    </form>
                </div> 
            </div>
    </div>
</div>


    
</body>
</html>