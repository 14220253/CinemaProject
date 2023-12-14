<?php
//FILE PHP INI SEBAGAI PLACEHOLDER UNTUK HOMEPAGE
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
}


if (isset($_GET["movie_id"])) {
    $movie_id = $_GET["movie_id"];
    $sql = "SELECT * FROM movie WHERE movie_id = $movie_id";
    $result = $mysqli->query($sql);
    $movies = $result->fetch_assoc();
    $supplierID = $movies["fk_supplier_id"];

    $produser = query("SELECT * FROM movie_supplier WHERE supplier_id = $supplierID");
} else {
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Detail</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- 
    <?php
    require_once "../Partials/header.php";
    ?> -->

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

        /* h1 {
            font-family: "Vina Sans", sans-serif;
        }

        h4 {
            font-weight: bold;
        } */

        .carousel-caption {
            background-color: rgb(16, 8, 94, 0.6);
            border-radius: 10px;
        }
    </style>
    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css" />
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;700;800&family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");
        

        * {
            font-family: "Quicksand", sans-serif;
        }




        label::before {
            content: ":";
            position: absolute;
            top: 0;
            right: 5px;
        }

        .label {
            width: 90px;
        }
    </style>
</head>

<body>
    <section></section>
    <div class="bg-mid"></div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark text-bg-dark sticky-top" ;>
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
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-outline-secondary" type="submit">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-2 p-lg-5 p-md-5 p-sm-3">
            <h1 class="h1 text-center text-light pt-4 pb-4" style="font-size: 3em; font-weight: bolder; font-family: 'League Spartan';">NOW PLAYING</h1>

            <div class="row">
                <div class="col-sm-5 col-12 col-md-5 col-lg-3 g-0 order-lg-1 order-2 pb-4">
                    <div class="poster p-sm-2 p-2 p-md-0 p-lg-0">
                        <a href="">
                            <img class="w-100" src="data:image;base64,<?= getMovie($movies["movie_id"]) ?>" alt="<?= $movies["movie_name"] ?>">
                        </a>
                        <div class="d-grid w-100">
                            <button type="button" class="btn btn-primary btn-block">
                                Buy Ticket
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9 text-light order-1 order-lg-2 pb-2 pb-md-4 ps-0 pe-0">
                    <iframe width="100%" height="100%" class="w-100" style="min-height: 400px;" src="<?= $movies["trailer"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>

                <div class="col order-3 p-4 text-light">
                    <h3 class="text-uppercase pb-3"><?= $movies["movie_name"] ?></h3>

                    <div class="row row-cols-2 row-cols-lg-3 row-cols-md-3 g-2 pb-3">

                        <?php

                        $genres = explode(",", $movies["genre"]);
                        foreach ($genres as $genre) :
                        ?>
                            <div class="col"><button data-aos="flip-right" data-aos-duration="2000" class="w-100 btn btn-outline-info btn-dark rounded-4" style="font-family: Verdana, Geneva, Tahoma, sans-serif;"><?= $genre ?></button></div>

                        <?php endforeach; ?>

                    </div>
                    <div class="row" data-aos="flip-right" data-aos-duration="2000">
                        <div class="col-1 label">Produser</div>
                        <div class="col-1" style="width: 3px;">:</div>
                        <div class="col"><?= $movies["produser"] ?></div>
                    </div>
                    <div class="row" data-aos="flip-right" data-aos-duration="2000">
                        <div class="col-1 label">Sutradara</div>
                        <div class="col-1" style="width: 3px;">:</div>
                        <div class="col"><?= $movies["sutradara"] ?></div>
                    </div>
                    <div class="row" data-aos="flip-right" data-aos-duration="2000">
                        <div class="col-1 label">Penulis</div>
                        <div class="col-1" style="width: 3px;">:</div>
                        <div class="col"><?= $movies["penulis"] ?></div>
                    </div>
                    <div class="row" data-aos="flip-right" data-aos-duration="2000">
                        <div class="col-1 label">Produksi</div>
                        <div class="col-1" style="width: 3px;">:</div>
                        <div class="col"><?= $produser[0]["supplier_name"] ?></div>
                    </div>

                    <div class="row" data-aos="flip-right" data-aos-duration="2000">
                        <div class="col-1 label">Cast</div>
                        <div class="col-1" style="width: 3px;">:</div>
                        <div class="col"><?= $movies["cast"] ?></div>
                    </div>

                    <!-- </div>
                    </div> -->
                </div>

                <div class="col-12 col-lg-6 text-warning order-last p-4">

                    <h5 class=" pb-3 text-secondary shadow-sm" data-aos="flip-right" data-aos-duration="2000"><?= floor($movies["movie_length"] / 60) ?> Hours <?= $movies["movie_length"] % 60 ?> Minutes <i class="bi bi-hourglass"></i></h5>
                    <!-- <h3 class="text-uppercase pb-3">Sinopsis</h3> -->


                    <button class="btn btn-dark btn-outline-warning w-100 mb-5" data-aos="flip-right" data-aos-duration="2000">PLAYING AT</button>

                    <p class="text" data-aos="flip-right" data-aos-duration="2000">
                        <?= $movies["movie_details"] ?>
                    </p>

                </div>

            </div>



        </div>
        <footer data-aos="zoom-in">
            <div class="container-fluid bg-dark text-light p-3">
                <div class="row">
                    <div class="col">
                        <h5 class="p-2">PCinemaU</h5>
                        <p class="p-2">PCinemaU adalah sebuah website yang menyediakan informasi film-film terkini dan terupdate</p>
                    </div>
                    <div class="col">
                        <h5>Navigation</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Home</a></li>
                            <li><a href="index.php#nowplaying">Now Playing</a></li>
                            <li><a href="index.php#upcoming">Upcoming</a></li>
                            <li><a href="index.php#theatre">Theatre</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <h5>Our Social Media</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Instagram</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <h5>Our Partner</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Cinema 21</a></li>
                            <li><a href="#">XXI</a></li>
                            <li><a href="#">CGV</a></li>
                            <li><a href="#">Cinepolis</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
     <!-- AOS -->
     <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>


<script>
    $(document).ready(function() {
        $(".poster").hover(function() {
            $(this).css("background-color", "rgba(0, 0, 0, 0.5)");
            $(this).css("transition", "0.5s");
        }, function() {
            $(this).css("background-color", "rgba(0, 0, 0, 0)");
            $(this).css("transition", "0.5s");
        });
    })
</script>
</body>

</html>