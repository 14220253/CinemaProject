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

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        * {
            font-family: "Quicksand", sans-serif;
        }

        /* .title {
            align-self: center;
            font-weight: bolder;
            margin: auto;
            font-size: xx-large;
        }

        .poster {
            width: 280px;
            height: 420px;
            margin-top: 40px;
            margin-left: 15px;
            margin-right: 20px;
            margin-bottom: 50px;
            float: left;
        }

        .posterTitle {
            align-self: center;
            font-size: large;
            color: white;
            text-align: center;
        }

        p {
            font-family: "Quicksand", sans-serif;
            color: white;
        }

        ul.no-bullets {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            color: white;
        }

        li.title {
            color: white;
            font-size: xx-large;
            font-weight: bolder;
        }

        .tab {
            display: inline-block;
            margin-left: 40px;
        } */
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
            <h1 class="text-center text-dark pt-4 pb-4">NOW PLAYING</h1>

            <div class="row row-cols-2">
                <div class="col-sm-4 col-12 col-md-5 col-lg-3 g-0 order-lg-1 order-2 pb-4">
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
                <div class="col-12 col-lg-9 text-light order-1 order-lg-2 pb-4 ps-0 pe-0">
                    <iframe width="100%" height="100%" class="w-100" style="min-height: 350px;" src="https://www.youtube.com/embed/giWIr7U1deA?si=dkp2l1590Z0rckDv" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>

                <div class="col order-last p-4">
                    <div class="row">
                        <div class="col text-warning">
                            <div class="row ">
                                <div class="col w-25">Genre</div>
                                <div class="col">:</div>
                                <div class="col">attribut</div>
                            </div>
                            <div class="row">
                                <div class="col w-25">Produser</div>
                                <div class="col">:</div>
                                <div class="col">attribut</div>
                            </div>
                            <div class="row">
                                <div class="col w-25">Sutradara</div>
                                <div class="col">:</div>
                                <div class="col">attribut</div>
                            </div>
                            <div class="row">
                                <div class="col w-25">Penulis</div>
                                <div class="col">:</div>
                                <div class="col">attribut</div>
                            </div>
                            <div class="row">
                                <div class="col w-25">Produksi</div>
                                <div class="col">:</div>
                                <div class="col">attribut</div>
                            </div>

                            <div class="row">
                                <div class="col w-25">Cast</div>
                                <div class="col">:</div>
                                <div class="col">attribut</div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>
    </div>
</body>

</html>