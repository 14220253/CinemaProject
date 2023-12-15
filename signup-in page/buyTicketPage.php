<?php
require "database.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once "../Partials/header.php" ?>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> -->

    <script>
    </script>
    <?php
    if (isset($_GET['id'])) {
        $movie_id = $_GET['id'];

        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pcinemau";
        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM movie WHERE movie_id = ?";
        $prepared = $conn->prepare($sql);
        $prepared->bind_param("i", $movie_id);
        if ($prepared == false) {
            throw new Exception($conn->error);
        }
        $prepared->execute();
        $result = $prepared->get_result();
        $row = $result->fetch_assoc();
    }
    ?>

    <style>
        .image-container {
            position: relative;
            width: 25%;
            padding-top: 33.33%;
            min-width: 200px;
            min-height: 266.66px;
            /* This sets the aspect ratio to 4:3. Adjust this value to get the aspect ratio you want. */
            overflow: hidden;
        }

        .image-container img.img-thumbnail {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

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
    <link rel="stylesheet" href="../Partials/general.css">
    <script src="../Partials/autoHoverBG.js"></script>

</head>

<body>

    <section></section>
    <div class="bg-mid"></div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark text-bg-dark sticky-top" ; style="width: 100vw;">
            <div class="container-fluid">
                <a class="navbar-brand ps-3" href="index.php" style="font-weight: bold">PCinemaU</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php#nowplaying"><i class="bi bi-camera-reels-fill"></i> Now
                                Playing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#upcoming"><i class="bi bi-film"></i> Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#theatre"><i class="bi bi-geo-alt-fill"></i>
                                Theatre</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="bi bi-person-circle"></i> Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if (!$guessUser) : ?>
                                    <li>
                                        <a class="dropdown-item" href=" logout.php">Log Out</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">My Data</a>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <a class="dropdown-item" href="../signup-in page/signin-page.php">Sign In</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="../signup-in page/signup-page.php">Sign Up</a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <!-- <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-outline-secondary" type="submit">
                            Search
                        </button>
                    </form> -->
                </div>
            </div>
        </nav>
        <div class="container-fluid pt-5">



            <div class="row gx-3">
                <div class="col-4 image-container ms-5">
                    <img class="img-thumbnail" src="data:image;base64,<?= getMovie($row["movie_id"]) ?>">//taruh movie_image
                </div>
                <div class="col">
                    <div class="text-light text-center pb-2">
                        <h5 class="h-6 text-uppercase"><?= $row["movie_name"] ?></h5>

                        <div class="border-bottom"></div>
                            
                            <h6 class="blockquote text-center pt-3"><?= $row["genre"] ?></h6>
                            <h6 class="text-light "><?= floor($row['movie_length']/60) . " Hours ".$row['movie_length']%60 ." Minutes"?></h6>
                    </div>

                    
                </div>
            </div>
            <div>
                <table class="table table-responsive" style="margin-top:35px;">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>
                                <h5>TUNJUNGAN XXI</h5>
                                </p>
                                <div class="row">
                                    <div class="col-10">
                                        <p class="d-inline justify-content-start">12-10-2023</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="d-inline justify-content-end">Rp. 35000</p>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-light" value="11:30">11:30</button>
                                        <button type="button" class="btn btn-light" value="13:30">13:30</button>
                                        <button type="button" class="btn btn-light" value="15:30">15:30</button>
                                        <button type="button" class="btn btn-light" value="17:30">17:30</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                <h5>TUNJUNGAN XXI</h5>
                                </p>
                                <div class="row">
                                    <div class="col-10">
                                        <p class="d-inline justify-content-start">12-10-2023</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="d-inline justify-content-end">Rp. 35000</p>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-light" value="11:30">11:30</button>
                                        <button type="button" class="btn btn-light" value="13:30">13:30</button>
                                        <button type="button" class="btn btn-light" value="15:30">15:30</button>
                                        <button type="button" class="btn btn-light" value="17:30">17:30</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                <h5>TUNJUNGAN XXI</h5>
                                </p>
                                <div class="row">
                                    <div class="col-10">
                                        <p class="d-inline justify-content-start">12-10-2023</p>
                                    </div>
                                    <div class="col-2">
                                        <p class="d-inline justify-content-end">Rp. 35000</p>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-light" value="11:30">11:30</button>
                                        <button type="button" class="btn btn-light" value="13:30">13:30</button>
                                        <button type="button" class="btn btn-light" value="15:30">15:30</button>
                                        <button type="button" class="btn btn-light" value="17:30">17:30</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>