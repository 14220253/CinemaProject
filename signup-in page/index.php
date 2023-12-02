<?php
//FILE PHP INI SEBAGAI PLACEHOLDER UNTUK HOMEPAGE
session_start();
$guessUser = false;
if (isset($_SESSION["login"])) {
    $mysqli = require __DIR__ . "/database.php";
    $data = $_SESSION["user_data"];
    $user_id = $data["customer_id"];

    $sql = "SELECT * FROM customer WHERE customer_id = '$user_id'";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $guessUser = false;
} else {
    $guessUser = true;
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
            font-family: 'Vina Sans', sans-serif;
        }

        h4 {
            font-weight: bold;
        }

        .carousel-caption {
            background-color: rgb(16, 8, 94, 0.6);
            border-radius: 10px;

        }
    </style>
    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">



</head>

<body>
    <section>

    </section>
    <div class="bg-mid">
    </div>

    <div class="content">

        <nav class="navbar navbar-expand-lg navbar-dark text-bg-dark sticky-top" ;>
            <div class="container-fluid">
                <a class="navbar-brand ps-3" href="#" style="font-weight: bold;">PCinemaU</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#nowplaying"><i class="bi bi-camera-reels-fill"></i> Now Playing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#upcoming"><i class="bi bi-film"></i> Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#theatre"><i class="bi bi-geo-alt-fill"></i> Theatre</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container text-light p-3">

            <!-- Carousel -->
            <div class="row mt-5">
                <div class="col-lg-9 col-12">
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="4"></button>
                        </div>

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="../Assets/Endgame.jpg" alt="" class="d-block" style="width:100%">

                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Avenger: Endgame</h4>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="../Assets/yourname.jpg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Kimi No Na Wa</h4>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="../Assets/Fast9.jpg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Fast 9</h4>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="../Assets/aquaman.jpeg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Aquaman: The Lost Kingdom</h4>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="../Assets/transformer.jpg" alt="" class="d-block" style="width:100%">
                                <div class="carousel-caption">
                                    <h4 class="pt-1 pe-2 ps-2">Transformer: Rise Of Extinction</h4>
                                </div>
                            </div>

                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>




                </div>
                <div class="col">
                    <?php
                    if (!$guessUser) : ?>

                        <div class="card" style="
background: rgb(251,246,63);
background: radial-gradient(circle, rgba(251,246,63,1) 0%, rgba(252,70,107,1) 100%);">
                            <div class="card-body">
                                <h1 class="card-title text-uppercase text-center" style="font-size:3em; ">WELCOME @<?php echo htmlspecialchars($user["username"]) ?></h1>
                            </div>
                            <div class="card-footer">
                                <div class="row row-cols-lg-1 row-cols-1 gy-1 row-cols-sm-2 row-cols-md-4">
                                    <div class="col">
                                        <a href="#" class="btn btn-dark w-100">Your Profile</a>
                                    </div>
                                    <div class="col">
                                        <a href="#" class="btn btn-dark w-100">Your Ticket</a>
                                    </div>
                                    <div class="col">
                                        <!-- <a href="#" class="btn btn-dark w-100">Filter Genre</a> -->
                                        <div class="dropdown h-100">
                                            <button type="button" class="btn btn-dark w-100 h-100 dropdown-toggle" data-bs-toggle="dropdown">
                                                Filter Genre
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- <a href="#" class="btn btn-dark w-100">Filter Year</a> -->
                                        <div class="dropdown h-100">
                                            <button type="button" class="btn btn-dark w-100 h-100 dropdown-toggle text-sm-center" data-bs-toggle="dropdown">
                                                Filter Year
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- //now playing section -->
            <h1 class="mt-5 mb-5" id="nowplaying" data-aos="flip-right" data-aos-duration="1000">NOW PLAYING</h1>


            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-2 mb-5">

                <?php for ($i = 0; $i < 20; $i++) : ?>
                    <div class="col">

                        <!-- <div class="card">
                    <div ></div> -->
                        <div class="card movie-card" data-aos="zoom-in-up" data-aos-delay="300" data-aos-duration="800">
                            <img class="card-img-top" src="https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//catalog-image/100/MTA-121903488/no-brand_no-brand_full02.jpg" alt="">
                            <div class="card-body">
                                <h6 class="card-title">Avenger: Endgame (2019)</h6>
                                <p class="card-text">Action, Adventure, Fantasy, Sci-fi</p>
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#MovieDetail">See Detail</a>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                <?php endfor; ?>

            </div>

            <!-- //upcoming -->
            <h1 class="mt-5 mb-5" id="upcoming" data-aos="flip-right" data-aos-duration="1000">UPCOMING MOVIE</h1>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-2 mb-5">
                <div class="col"></div>
            </div>


            <h1 class="mt-5 mb-5" id="theatre" data-aos="flip-right" data-aos-duration="1000">Theatre</h1>

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
    <div class="modal modal-fullscreen-sm-down" id="MovieDetail">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Movie Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body text-bg-dark" >
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2" >
                        <div class="col">
                        <img src="https://s1.bukalapak.com/img/68286857232/large/Poster_Film___Avengers_Endgame___Marvel_Studios___Movie_Post.jpg" alt="" style="width: 100%;">
                        </div>
                        <div class="col">

                            <table class="my-2">
                                <tr>
                                    <td>Genre</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                <td>Duration</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                <td>Release Date</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                <td>Director</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                <td>Cast</td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>Synopsis</td>
                                    <td>:</td>
                                </tr>
                                

                                
                            </table>
                            
                            <script>
                                $(document).ready(function(){
                                    $("#MovieDetail").find("td").addClass("pe-2");
                                })
                            </script>
                        </div>
                        
                    </div>
                    <p class="pt-3 p-1 float-end" style="text-align: justify;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum quis asperiores ipsam enim cupiditate vel repellat ad quas consequatur minima! Eveniet adipisci ab facilis harum fugit aliquam laborum. Reprehenderit, aut!
                    </p>
                                

                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>







    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>