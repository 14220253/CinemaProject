<?php
require "database.php";
session_start();
// require __DIR__ . "/database.php";
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

        $sql2 = "SELECT * FROM detail_penayangan ds JOIN movie m ON (m.movie_id= ds.fk_movie_id) JOIN data_theatre t ON (t.theatre_id = ds.fk_theatre_id) JOIN schedule_hours s ON (ds.detail_penayangan_id = s.fk_detail_penayangan_id) WHERE fk_movie_id = ?";
        $prepared = $conn->prepare($sql2);
        $prepared->bind_param("i", $movie_id);
        if ($prepared === false) {
            throw new Exception($conn->error);
        }

        $prepared->execute();
        $result = $prepared->get_result();
        // $row = $result->fetch_assoc();




        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        if (count($rows) == 0) {
            header("Location:upcomingdetail.php?movie_id=$movie_id");
        }

        $theatre = [];
        foreach ($rows as $row) {
            $theatre[] = $row["theatre_name"];
        }

        

        $theatre = array_unique($theatre);
    }
    else {
        header("Location: index.php");
    }
    ?>

    <style>
        .image-container {
            position: relative;
            width: 15%;
            padding-top: 20%;
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
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

</head>

<body style="overflow-x: hidden;">

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

                                
                            </ul>
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
        <div class="container pt-5 px-5 pb-4">



            <div class="row gx-3">
                <div class="col-4 image-container ms-auto me-auto mb-3">
                    <img class="img-thumbnail" src="data:image;base64,<?= getMovie($row["movie_id"]) ?>">//taruh movie_image
                </div>
                <div class="col ">
                    <div class="text-light text-center pb-2">
                        <h5 class="h-6 text-uppercase"><?= $row["movie_name"]?></h5>

                        <div class="border-bottom"></div>

                        <h6 class="blockquote text-center pt-3"><?= $row["genre"] ?></h6>
                        <h6 class="text-light "><?= floor($row['movie_length'] / 60) . " Hours " . $row['movie_length'] % 60 . " Minutes" ?></h6>
                    </div>


                </div>
            </div>
            <div>
                <table class="table table-responsive table-dark text-light" style="margin-top:35px;">
                    <?php foreach ($theatre as $t) : ?>

                        <?php
                        foreach ($rows as $row) {
                            if ($row["theatre_name"] == $t) {
                                $start_date = new DateTime($row["start_date"]);
                                $end_date = new DateTime($row["end_date"]);
                                $price = $row["harga_tiket"];
                                break;
                            }
                        }
                        $current_date = clone $start_date;

                        ?>
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <h4 class="text-uppercase pt-3 px-2 theatre"><?= $t ?></h4>
                                </td>
                            </tr>

                        </thead>
                        <tbody>
                            <?php while ($current_date <= $end_date) : ?>
                                <tr>
                                    <td>
                                        <h6 class="ps-2 dateFilm"><?= $current_date->format('Y-m-d') ?></h6>

                                        <div class="row">
                                            <div class="col-10">
                                                <!-- <p class="d-inline justify-content-start">12-10-2023</p> -->
                                                <?php foreach ($rows as $row) {
                                                    if ($row["theatre_name"] == $t) {
                                                        echo "<button type='button' class='btn btn-outline-warning hours m-2' style='min-width: 80px;' value=" . $row['jam_penayangan'] . ">" . $row['jam_penayangan'] . "</button>";
                                                    }
                                                } ?>

                                            </div>
                                            <div class="col-2">
                                                <p class="d-inline justify-content-end">Rp. <?=number_format($price, 2, '.', ',');?></p>
                                            </div>
                                            <div class="col-12">

                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                            <?php $current_date->modify('+1 day');
                            endwhile; ?>

                        </tbody>
                    <?php endforeach; ?>
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
                        <input type="hidden" name="movie_id" value="<?=$movie_id?>" class="data_movie">
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

    </div>




    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    
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
                console.log(time);

                let theatre = $(this).closest("tbody").prev("thead").find(".theatre").text();
                let tanggal = $(this).closest("td").find(".dateFilm").text();
                console.log(theatre);
                console.log(tanggal);
                console.log($(".data_movie").val());
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