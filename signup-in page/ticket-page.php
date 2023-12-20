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

$user_id = getUserID($data);
echo $user_id;
$sql = "SELECT distinct timestamp, fk_detail_penayangan_id 
FROM tiket t join movie m ON (t.fk_movie_id = m.movie_id) 
JOIN schedule_hours sh ON (sh.schedule_hours_id = t.fk_schedule_hours_id) 
JOIN detail_penayangan dp ON (dp.detail_penayangan_id = sh.fk_detail_penayangan_id) 
JOIN data_theatre dt ON (dt.theatre_id = dp.fk_theatre_id) 
WHERE fk_customer_id = $user_id ORDER BY tiket_id DESC;";
$data_ticket = query($sql);




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PCinemaU</title>
    <link rel="icon" type="image" href="../Partials/favIcon.png"/>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap" rel="stylesheet" />


    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css">
    <link rel="stylesheet" href="../Partials/confeti.css">
    <!-- AOS -->
    <!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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

        .label {
            width: 90px;
            font-weight: bold;
        }
    </style>
</head>

<body style="overflow-x: hidden;">
    <section></section>
    <div class="bg-mid"></div>
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
        <div class="container" style="min-height: 500px;">
            <div class="">
                <?php if (count($data_ticket) > 0):?>
                <?php foreach ($data_ticket as $dataT) : ?>
                    <?php
                    $ts = $dataT["timestamp"];
                    $detail = $dataT["fk_detail_penayangan_id"];
                    $transaksi = query("SELECT fk_theatre_id, tiket_id, movie_name, theatre_name, fk_kursi_id, price, date, jam_penayangan, timestamp 
                        FROM tiket t join movie m ON (t.fk_movie_id = m.movie_id) 
                        JOIN schedule_hours sh ON (sh.schedule_hours_id = t.fk_schedule_hours_id) 
                        JOIN detail_penayangan dp ON (dp.detail_penayangan_id = sh.fk_detail_penayangan_id) 
                        JOIN data_theatre dt ON (dt.theatre_id = dp.fk_theatre_id) 
                        WHERE fk_customer_id = $user_id AND 
                        fk_detail_penayangan_id = $detail AND timestamp = '$ts' ORDER BY tiket_id DESC;");

                    $seat = [];
                    $mName = [];
                    $id = [];
                    $theatre_name = [];
                    $date = [];
                    $time = [];
                    $total = 0;
                    $price = [];
                    $tiket_count = 0;
                    $thea_id = [];
                    foreach ($transaksi as $ticketRef) {
                        $seat[] = $ticketRef["fk_kursi_id"];
                        $total += $ticketRef["price"];
                        $mName[] = $ticketRef["movie_name"];
                        $id[] = $ticketRef["tiket_id"];
                        $thea_id[] = $ticketRef["fk_theatre_id"];
                        $theatre_name[] = $ticketRef["theatre_name"];
                        $date[] = $ticketRef["date"];
                        $time[] = $ticketRef["jam_penayangan"];
                        $price[] = $ticketRef["price"];
                        $tiket_count++;
                    }
                    $mName = array_unique($mName);
                    $id = array_unique($id);
                    $theatre_name = array_unique($theatre_name);
                    $date = array_unique($date);
                    $time = array_unique($time);
                    $price = array_unique($price);
                    $thea_id = array_unique($thea_id);
                    $theatr = implode(", ", $thea_id);



                    $mName = implode(", ", $mName);
                    $id = implode(", ", $id);
                    $theatre_name = implode(", ", $theatre_name);
                    $date = implode(", ", $date);
                    $time = implode(", ", $time);
                    $seat = implode(", ", $seat);
                    $price = implode(", ", $price);
                    $ref = $user_id . '/' . (new DateTime($ts))->format('Ymdhis') . '/' . (new DateTime($date))->format('Ymd') . '/' . $theatr;

                    $sql3 = "SELECT movie_image, movie_id from movie where movie_name = '$mName'";
                    $poster = query($sql3);
                    ?>

                    <div class="m-2 bg-dark">

                        <div class="col w-100" style="overflow-x: auto;">
                            <table class="table table-striped table-secondary w-100 p-1 mt-2"  style="min-width: 700px;">
                                <tr>
                                    <td rowspan="8" style="min-width: 250px; max-width:25%">

                                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                            <div class="image-container d-flex flex-wrap justify-content-center align-content-center">
                                                <a href="moviedetail.php?movie_id=<?= $poster[0]["movie_id"] ?>" class="text-decoration-none text-dark">
                                                    <img class="card-img-top" style="object-fit: cover ;" src="data:image;base64,<?php echo base64_encode($poster[0]["movie_image"]); ?>" alt="<?= $mName ?>">
                                                </a>
                                            </div>
                                            <button class="btn btn-success w-100 " data-bs-toggle="modal" data-bs-target="#qrModal" value="<?php echo htmlspecialchars($ref) ?>">Show QR</button>
                                        </div>

                                    </td>

                                    <th colspan="2" style="text-align: center; vertical-align: middle;">
                                        <h1 class="text-uppercase h4" style="font-weight: bold;"><?= $mName ?></h1>
                                    </th>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h1 class="h6 ps-1"><?= $theatre_name ?></h1>
                                    </td>
                                </tr>
                                <tr>

                                    <td class="w-50" colspan="">
                                        <div class="row">
                                            <div class="col-1 label">Date</div>
                                            <div class="col-1" style="width: 3px;">:</div>
                                            <div class="col"><?php echo (date('l', strtotime(htmlspecialchars($date))) . ", " . (new DateTime($date))->format('d-m-Y')) ?> </div>
                                        </div>
                                    </td>
                                    <td class="w-50" colspan="">
                                        <div class="row">
                                            <div class="col-1 label">Time</div>
                                            <div class="col-1" style="width: 3px;">:</div>
                                            <div class="col"><?php echo htmlspecialchars($time) ?></div>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="label">Seat</td>
                                    <td><?php echo htmlspecialchars($seat) ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Total Tickets</td>
                                    <td><?php echo htmlspecialchars($tiket_count) ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Ticket Price</td>
                                    <td><?php echo htmlspecialchars($price) ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Total Order</td>
                                    <td><?php echo htmlspecialchars($total) ?></td>
                                </tr>
                                <tr>
                                    <td class="label">Ticket Ref</td>
                                    <td><?php echo htmlspecialchars($ref) ?></td>

                                </tr>

                            </table>
                        </div>

                    </div>


                <?php endforeach; ?>
                <?php else:?>
                    <div class="container d-flex flex-wrap justify-content-center align-content-center" style="min-height: 400px;">
                        <h1 class="display-2 text-center text-danger shadow-lg" style="font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif;">NO RECORD</h1>
                    </div>

                <?php endif;?>

            </div>
        </div>


        <footer data-aos="zoom-in">
            <div class="container-fluid bg-dark text-light p-3">
                <div class="row">
                    <div class="col">
                        <h5 class="ps-3">PCinemaU</h5>
                        <p class="p-2 ps-3">PCinemaU adalah sebuah website yang menyediakan informasi film-film terkini dan terupdate</p>
                    </div>
                    <div class="col">
                        <h5>Navigation</h5>
                        <ul class="list-unstyled">
                            <li><a href="index.php">Home</a></li>
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

    <!-- make modal to show qr -->
    <div id="qrModal" class="modal fade bd-example-modal" tabindex="-1" role="
    dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-head">
                    <h5 class="modal-title p-2 text-bg-dark h6" id="exampleModalLabel">QR Code</h5>
                </div>
                <div class="modal-body bg-warning" style="min-width: 200px; max-width: 500px;" id="qrImage">
                    <!-- <div class="row">
                        <div class="col-6"> -->
                    <div class="d-flex">
                        <img class="card-img-top" style="object-fit: cover ;" src="../Partials/noImage.jpg" alt="qr">
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>


        </div>

    </div>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.btn-success').click(function() {
                var ref = $(this).val();
                var url = "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=" + ref;
                $('#qrModal img').attr('src', url);
                $(".modal-title").html("REF: " + ref);
                $('#qrModal').modal('show');
            });
        });
    </script>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // console.log("Initializing AOS...");
        AOS.init();
    </script>

</body>

</html>