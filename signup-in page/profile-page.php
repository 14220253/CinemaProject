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
} else {
    $guessUser = true;
    header("Location: /signup-in page/signin-page.php");
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        require_once "../Partials/header.php";
        ?>

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>

        <!-- Bootstrap -->
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
        <!-- Icon -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"
        />
        <!-- jquery -->
        <script
            src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"
        ></script>

        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap"
            rel="stylesheet"
        />

        <style>
            div.content {
                position: absolute;
                width: 100vw;
                height: 100vh;
                display: flex;
                justify-content: left;
                align-items: flex-start; 
                z-index: 10;
            }
            

            div.content-inner {
                position: relative;
                width: 100vw;
                height: 100vh;
            }

            div.bg-mid {
                position: fixed;
                width: 100vw;
                min-height: 100vh;
                z-index: 8;
                background-color: #181818;
                filter: blur(5px);
                opacity: 0.8;
            }

            div.profile {
                width: 70%;
                background: #222;
                z-index: 1000;
                display: flex;
                flex-direction: column; 
                justify-content: center;
                align-items: left;
                padding: 40px;
                border-radius: 4px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.9);
                margin-top: 1.5%;
                margin-left: 5%;
            } 

            div.profile h1{
                text-align: left;
                 color: rgb(0, 170, 255);
            }

            .stats {
                margin-top: 75px;
                text-align: left;
                color: white;
                font-size: 1.7em;
            }

            .space {
                margin-top: 25px;
            }

            .stats a{
                text-decoration:none;
                color: lightblue;
            }

            .stats a:hover{
                text-decoration:underline;
                color: aqua;
            }

            .stats .delete {
                color: firebrick;
                text-decoration: none;
            }

            .stats .delete:hover{
                color: red;
                text-decoration: underline;
            }

            .stats .edit{
                color: lightgreen;
                text-decoration: none;
            }
            .stats .edit:hover{
                color: chartreuse;
                text-decoration: underline;
            }

            .stats .data{
                color: rgb(0, 170, 255);
            }
        </style>
        <script src="../Partials/autoHoverBG.js"></script>
        <link rel="stylesheet" href="../Partials/general.css" />
    </head>
    <body>
        <section></section>
        <div class="bg-mid"></div>

        <div class="content">
            <div class="profile">
                <div class="row">
                    <div  class="col-7" >
                        <h1 class="card-title text-uppercase" style="font-size:3em; "><b>YOUR PROFILE</b></h1>
                    </div>
                    <div class="col-5">
                        <h1 class="card-title text-uppercase" style="font-size:2.5em;"><b>RECENT MOVIES</b></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <div class="stats">
                            <p><b class="data">Name:</b> <?php echo htmlspecialchars($user["name"]) ?> </p>
                            <p><b class="data">Username:</b> <?php echo htmlspecialchars($user["username"]) ?> </p>
                            <p><b class="data">Phone Number:</b> <?php echo htmlspecialchars($user["phone_number"]) ?> </p>
                            <p><b class="data">Address:</b> <?php echo htmlspecialchars($user["address"]) ?> </p>
                        </div>
                        <div class="stats">
                            <a href="profileedit-page.php" class="edit"><b>Edit Profile</b></a> <br>
                            <a href="changepassword-page.php"><b>Change Password</b></a> <br>
                            <a href="deleteaccount-page.php" class="delete"><b>Delete Account</b></a>
                            <br>
                            <a class="btn btn-secondary w-25" href="index.php"><b style="color:white;">Back</b></a>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="row row-cols-2">

                        <?php for ($i = 0; $i < 2; $i++) : ?>
                            <div class="col">
                                <div class="card movie-card" data-aos="zoom-in-up" data-aos-delay="300" data-aos-duration="800">
                                    <img class="card-img-top" src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-121903488/no-brand_no-brand_full02.jpg" alt="">
                                    <div class="card-body">
                                        <h6 class="card-title">Avenger: Endgame (2019)</h6>
                                        <p class="card-text">Action, Adventure, Fantasy, Sci-fi</p>
                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#MovieDetail">See Detail</a>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>

                        </div>
                        <div class="space row"></div>
                        <button class="btn btn-warning w-100">See More</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
