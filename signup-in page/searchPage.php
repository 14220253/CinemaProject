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


$nowPlaying = query("SELECT * FROM movie");
// $upcoming = query("SELECT * FROM movie");

if (isset($_GET["search"])) {
    $key = $_GET["key"];
} else {
    $key = "";
}
if ($_GET["genre"] == "All") {
    $nowPlaying = query("SELECT * FROM movie WHERE movie_name LIKE '%$key%'");
} else {
    $genre = $_GET["genre"];
    $nowPlaying = query("SELECT * FROM movie WHERE movie_name LIKE '%$key%' AND genre LIKE '%$genre%'");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    require_once "../Partials/header.php";
    ?>




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

        h1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h4 {
            font-weight: bold;
        }

        .carousel-caption {
            background-color: rgb(16, 8, 94, 0.6);
            border-radius: 10px;

        }

        .image-container {
            position: relative;
            width: 100%;
            padding-top: 133.33%;
            /* This sets the aspect ratio to 4:3. Adjust this value to get the aspect ratio you want. */
            overflow: hidden;
        }

        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-container:hover {
            transform: scale(1.2);
            transition: transform .2s;
        }


        .movie-title:hover {
            color: red !important;
        }
    </style>
    </styl>
    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




</head>

<body style="overflow-x: hidden;">
    <section>

    </section>
    <div class="bg-mid">
    </div>

    <div class="content">

        <nav class="navbar navbar-expand-lg navbar-dark text-bg-dark sticky-top" ;>
            <div class="container-fluid">
                <a class="navbar-brand ps-3" href="index.php" style="font-weight: bold;">PCinemaU</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php#nowplaying"><i class="bi bi-camera-reels-fill"></i> Now Playing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#upcoming"><i class="bi bi-film"></i> Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#theatre"><i class="bi bi-geo-alt-fill"></i> Theatre</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="bi bi-person-circle"></i> Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">


                                <?php if (!$guessUser) : ?>
                                    <li><a class="dropdown-item" href=" logout.php">Log Out</a></li>
                                    <li><a class="dropdown-item" href="#">My Data</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="../signup-in page/signin-page.php">Sign In</a></li>
                                    <li><a class="dropdown-item" href="../signup-in page/signup-page.php">Sign Up</a></li>
                                <?php endif; ?>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" action="" method="get">
                        <!-- <div class="dropdown h-100"> -->


                        <select class="form-select w-75 me-2" name="genre">

                            <option><span class="dropdown-item genre">All</span></option>
                            <?php
                            $movieGenres = [
                                "Action",
                                "Comedy",
                                "Drama",
                                "Sci-Fi",
                                "Horror",
                                "Romance",
                                "Thriller",
                                "Adventure",
                                "Animation",
                                "Fantasy",
                                "Crime",
                                "Family"
                            ];

                            foreach ($movieGenres as $genre) : ?>
                                <option><span class="dropdown-item genre"><?= $genre ?></span></option>
                            <?php endforeach;
                            ?>


                        </select>
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="key" id="key">
                        <button class="btn btn-outline-secondary" type="submit" name="search" id="search">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container text-light ps-5 pt-3 w-75 ajax-container" style="min-height: 500px;">


            <!-- //now playing section -->
            <?php if (isset($_GET["key"]) && strlen($_GET["key"]) > 0) : ?>
                <h2 class="text-start text-uppercase">Hasil Pencarian: <?= $key ?></h2> 
                <h4 class="text-start ">Genre: <?= $_GET["genre"] ?></h4>
                <p class="blockquote text-start border-bottom border-2 pb-5"><?=count($nowPlaying)?> result</p>

            <?php endif; ?>
            <?php if ($_GET["genre"] != "All") : ?>
                
            <?php endif ?>
            

            

            <?php if (count($nowPlaying) > 0) : ?>
                <?php foreach ($nowPlaying as $movie) : ?>
                    <?php //if($movie["status"] == 1):
                    ?>

                    <div class="row row-cols-lg-2 row-cols-1 row-cols-sm-1 row-cols-md-2 g-2 mb-5 mt-5">


                        <div class="col-lg-5">

                            <!-- <div class="card">
                    <div ></div> -->
                            <div class="card movie-card w-75 m-auto">
                                <a href="upcomingdetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-dark">
                                    <div class="image-container" style="">
                                        <img class="card-img-top" style="object-fit: cover ;" src="data:image;base64,<?php getMovie($movie["movie_id"]) ?>" alt="<?= $movie["movie_name"] ?>">

                                    </div>
                                </a>



                            </div>

                        </div>
                        <div class="col">
                            <a href="upcomingdetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-light">

                                <h4 class="pt-2 text-center text-md-start text-lg-start text-sm-center text-uppercase pb-2 text-warning movie-title"><b><?= $movie["movie_name"] ?></b></h4>
                                <p class="h6 pb-2 card-title text-center text-md-start text-lg-start text-sm-center"><?= $movie["genre"] ?></p>
                                <ul>
                                    <li class="card-text text-start"><b>Sutradara: </b><?= $movie["sutradara"] ?></li>
                                    <li class="card-text text-start"><b>Penulis: </b><?= $movie["penulis"] ?></li>
                                    <li class="card-text text-start"><b>Produser: </b><?= $movie["produser"] ?></li>
                                </ul>
                            </a>
                        </div>
                    </div>

                    <hr class="border-2">
                    <?php //endif; 
                    ?>
                <?php endforeach; ?>
                <!-- //upcoming -->
            <?php else : ?>
                <h1 class="display-1 text-danger text-center p-5 shadow-lg" style="font-weight: bold;">NO RESULT</h1>
            <?php endif; ?>

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
                            <li><a href="#nowplaying">Now Playing</a></li>
                            <li><a href="#upcoming">Upcoming</a></li>
                            <li><a href="#">Theatre</a></li>
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


    <!-- Modal -->
    <!-- Button to Open the Modal -->


    <!-- The Modal -->


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
    <script>
        $(document).ready(function() {
            $("#theatreTable").DataTable();
        });
    </script>
</body>

</html>