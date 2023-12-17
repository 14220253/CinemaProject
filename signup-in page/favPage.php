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
    header("Location: /signup-in page/signin-page.php");
}

$user_id = getUserID($data);
$sql = "SELECT * FROM fav_movie f join movie m ON (f.movie_id = m.movie_id) WHERE f.user_id = $user_id";
$favMovies = query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCinemaU</title>
    <link rel="icon" type="image/png" href="../Partials/favIcon.png">
    <?php require "../Partials/header.php" ?>
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
        .image-container {
            position: relative;
            width: 100%;
            padding-top: 133.33%;
            /* This sets the aspect ratio to 4:3. Adjust this value to get the aspect ratio you want. */
            overflow: hidden;
            transform-style: preserve-3d;
            transition: transform 1s;
        }

        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        .image-container img {
            object-fit: cover;
        }
    </style>
    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css">
    <link rel="stylesheet" href="../Partials/confeti.css">
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
                                    <li><a class="dropdown-item" href="profile-page.php">My Data</a></li>
                                    <li><a class="dropdown-item" href=" logout.php">Log Out</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="../signup-in page/signin-page.php">Sign In</a></li>
                                    <li><a class="dropdown-item" href="../signup-in page/signup-page.php">Sign Up</a></li>
                                <?php endif; ?>


                            </ul>
                        </li>

                    </ul>
                    <form class="d-flex" method="get" action="searchPage.php">
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
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="key">
                        <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container w-75 text-light">
            <h1 class="text-center text-uppercase border-2 border-bottom p-4">My Favorite Movie</h1>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Movie</th>
                        <th>Info</th>
                        <th>Sinopsis</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($favMovies as $movie) : ?>
                        <tr>
                            <td class="" style="width: 15%;">
                                <div class="image-container">

                                    <a href="upcomingdetail.php?movie_id=<?= $movie["movie_id"] ?>" class="text-decoration-none text-dark">
                                        <img class="card-img-top" style="object-fit: cover ;" src="data:image;base64,<?php getMovie($movie["movie_id"]) ?>" alt="<?= $movie["movie_name"] ?>">
                                    </a>
                                </div>
                            </td>
                            <td>
                                <h6><?= $movie["movie_name"] ?></h6>
                                <p><?= $movie["genre"] ?></p>
                            </td>
                            <td>
                            <div style="overflow-y: auto; height: 200px;">
                            <?= $movie["movie_details"] ?>
                            </div>    
                            
                            </td>
                            
                            <td><a href="movieDetail.php?id=<?= $movie["movie_id"] ?>" class="btn btn-dark">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        </div>



    </div>


</body>

</html>