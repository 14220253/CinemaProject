<?php
    // header("Location: signup-in page/index.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCinemaU</title>

    <?php require "Partials/header.php";?>
    <link rel="icon" type="image/png" href="Partials/favIcon.png">

    
    <script src="Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="Partials/general.css">
    <style>
        div.content {
            position: absolute;
            width: 100vw;
            height: 100vh;
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
    </style>
</head>
<body>
    <section></section>
    <div class="bg-mid"></div>
    <div class="content d-flex flex-wrap align-content-center">
        <div class=" container bg-dark d-flex justify-content-center flex-wrap align-content-center rounded-5" style="width: 20%; min-width: 200px; height: 30%;">
            <a href="Admin" class="text-uppercase btn btn-outline-danger p-2 m-2 w-100" style="font-weight: bold;">Admin Page</a>
            <a href="signup-in page" class="text-uppercase btn btn-outline-warning m-2 p-2 w-100" style="font-weight: bold;">User Page</a>

        </div>
    </div>
    
</body>
</html>
