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

        iframe-container {
            position: relative;
        }

        .iframe-loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            /* background-color: rgba(255, 255, 255, 0.7); */
        }

        .lds-facebook {
            display: inline-block;
            position: relative;

            width: 80px;
            height: 80px;
        }

        .lds-facebook div {
            display: inline-block;
            position: absolute;
            left: 8px;
            width: 16px;
            background: #fff;
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }

        .lds-facebook div:nth-child(1) {
            left: 8px;
            animation-delay: -0.24s;
        }

        .lds-facebook div:nth-child(2) {
            left: 32px;
            animation-delay: -0.12s;
        }

        .lds-facebook div:nth-child(3) {
            left: 56px;
            animation-delay: 0;
        }

        @keyframes lds-facebook {
            0% {
                top: 8px;
                height: 64px;
            }

            50%,
            100% {
                top: 24px;
                height: 32px;
            }
        }

        .scrollable-div {
            overflow: auto;
            height: 250px;
        }

        /* For Firefox */
        .scrollable-div {
            scrollbar-width: thin;
        }

        /* For Internet Explorer and Edge */
        .scrollable-div {
            -ms-overflow-style: none;
        }

        /* For Chrome, Safari and Opera */
        .scrollable-div::-webkit-scrollbar {
            width: 2px;
        }

        .scrollable-div::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollable-div::-webkit-scrollbar-thumb {
            background: #888;
        }

        .scrollable-div::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <?php if (isset($_GET["err"])) {
        if ($_GET["err"] == 1) {
            echo "<script>
            $(document).ready(function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Please input number between 1 and 10'
                })
            })";
            echo "</script>";
            $_GET["err"] = 0;
        } else if ($_GET["err"] == 2) {
            echo "<script>
            $(document).ready(function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Sorry no more available seat'
                })
            })";
            echo "</script>";
            $_GET["err"] = 0;
        }
    } ?>
</head>

<body style="overflow-x: hidden;">

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

        <script>
            function hideLoader() {
                document.getElementById("iframeLoader").style.display = "none";
            }
        </script>

        <div class="container-fluid p-2 p-lg-5 p-md-5 p-sm-3">
            <h1 class="h1 text-center text-light pt-4 pb-4" style="font-size: 3em; font-weight: bolder; font-family: 'League Spartan';">NOW PLAYING</h1>

            <div class="row">
                <div class="col-sm-5 col-12 col-md-5 col-lg-3 g-0 order-lg-1 order-2 pb-4">
                    <div class="poster p-sm-2 p-2 p-md-0 p-lg-0">
                        <a href="">
                            <img class="w-100" src="data:image;base64,<?= getMovie($movies["movie_id"]) ?>" alt="<?= $movies["movie_name"] ?>">
                        </a>
                        <div class="d-grid w-100">
                            <a href="buyTicketPage.php?id=<?= $movies["movie_id"] ?>" class="btn btn-primary btn-block">
                                Buy Ticket
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9 text-light order-1 order-lg-2 pb-2 pb-md-4 ps-0 pe-0 iframe-container" style="position: relative;">
                    <div class="iframe-loader" id="iframeLoader">
                        <div class="lds-facebook">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                    <iframe width="100%" height="100%" class="w-100" style="min-height: 300px;" src="<?= $movies["trailer"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen onload="hideLoader()"></iframe>
                </div>

                <div class="col order-3 p-4 text-light">
                    <h3 class="text-uppercase pb-3"><?= $movies["movie_name"] ?></h3>

                    <div class="row row-cols-2 row-cols-lg-3 row-cols-md-3 g-2 pb-3">

                        <?php

                        $genres = explode(",", $movies["genre"]);
                        foreach ($genres as $genre) :
                        ?>
                            <div class="col"><a href="searchPage.php?genre=<?= $genre ?>" data-aos="flip-right" data-aos-duration="2000" class="w-100 btn btn-outline-info btn-dark rounded-4" style="font-family: Verdana, Geneva, Tahoma, sans-serif;"><?= $genre ?></a></div>

                        <?php endforeach; ?>

                    </div>
                    <div class="scrollable-div">

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

                    </div>



                </div>

                <div class="col-12 col-lg-6 text-warning order-last p-4">

                    <h5 class=" pb-3 text-secondary shadow-sm" data-aos="flip-right" data-aos-duration="2000"><?= floor($movies["movie_length"] / 60) ?> Hours <?= $movies["movie_length"] % 60 ?> Minutes <i class="bi bi-hourglass"></i></h5>

                    <button class="playing-at btn btn-dark btn-outline-warning w-100 mb-5" data-aos="flip-right" data-aos-duration="2000" style="font-family: Verdana, Geneva, Tahoma, sans-serif;">PLAYING AT</button>
                    <div class="scrollable-div">
                        <p class="text" data-aos="flip-right" data-aos-duration="2000">
                            <?= $movies["movie_details"] ?>
                        </p>

                    </div>

                </div>

            </div>
            <div class="container-fluid  text-light" style="overflow-x: auto;">
                <table class="ajax-table table-hover table table-dark table-stripped table-responsive mx-0">

                </table>

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
            $(".ajax-table").hide();
            let status = false;
            $(".playing-at").on("click", function() {
                if (status == false) {
                    $(".ajax-table").show();
                    status = true;
                    $.ajax({
                        url: "showPlayingAt.php",
                        data: {
                            id: <?= $movies["movie_id"] ?>,
                            theatre_id: 1
                        },
                        method: "GET",
                        success: function(data) {
                            $(".ajax-table").html(data);
                        }
                    })
                } else {
                    $(".ajax-table").hide();
                    status = false;
                }
            })
        });
    </script>

    <div class="modal  fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select tickets</h5>
                    <button style="border-style: none;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>
                <form method="post" action="cinemaSeatPage.php">
                    <div class="modal-body">
                        <input type="hidden" name="theatre" class="data_theatre">
                        <input type="hidden" name="time" class="data_time">
                        <input type="hidden" name="date" class="data_date">
                        <input type="hidden" name="movie_id" value="<?= $movies["movie_id"] ?>" class="data_movie">
                        <!-- <div class="form-group"> -->
                        <label for="select_ticket">Select tickets</label>
                        <input class="form-control" type="number" id="select_ticket" name="select_ticket" min="1" max="10">
                        <!-- </div> -->

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-danger cancelButton" style="min-width: 30%;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success continueButton" style="min-width: 30%;" name="submit">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $(".cancelButton").on("click", function() {
                $(".select_theatre").val("");
                $(".select_time").val("");
                $("#select_ticket").val("");
            })

            $(document).on("click", ".hours", function() {
                event.preventDefault();
                let time = $(this).val();
                // console.log(time);

                let theatre = $(this).closest("table").closest("tr").find(".theatre").text();
                let tanggal = $(this).closest("tr").find(".dateFilm").text();
                // console.log(theatre);
                //show modal
                $("#exampleModal").find(".data_theatre").val(theatre);
                $("#exampleModal").find(".data_time").val(time);
                $("#exampleModal").find(".data_date").val(tanggal);

                $("#exampleModal").modal("show");
            })

        })
    </script>


</body>

</html>