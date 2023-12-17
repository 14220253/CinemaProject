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
$sql = "SELECT * FROM tiket t join movie m ON (t.fk_movie_id = m.movie_id) JOIN schedule_hours sh ON (sh.schedule_hours_id = t.fk_schedule_hours_id) WHERE fk_customer_id = $user_id";
$historys = query($sql);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once "../Partials/header.php";
    ?>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

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

    <style>
        div.content {
            position: absolute;
            width: 100vw;
            height: 100vh;
            /* display: flex;
            justify-content: left;
            align-items: flex-start; */
            z-index: 10;
        }

        .label {
            width: 90px;
            font-weight: bold;
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
    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css" />
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



        <div class="profile container mt-5 mb-5 bg-secondary shadow-lg w-75 rounded-3">
            <div class="row bg-dark p-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 text-light">
                    <h1 class="card-title text-uppercase text-light"><b>YOUR PROFILE</b></h1>
                    <!-- User data -->

                    <div class="p-4">
                        <div class="row" data-aos="flip-right" data-aos-duration="2000">
                            <div class="col-1 label">Nama</div>
                            <div class="col-1" style="width: 3px;">:</div>
                            <div class="col"><?php echo htmlspecialchars($user["name"]) ?> </div>
                        </div>
                        <div class="row" data-aos="flip-right" data-aos-duration="2000">
                            <div class="col-1 label">Username</div>
                            <div class="col-1" style="width: 3px;">:</div>
                            <div class="col"><?php echo htmlspecialchars($user["username"]) ?></div>
                        </div>
                        <div class="row" data-aos="flip-right" data-aos-duration="2000">
                            <div class="col-1 label">Phone</div>
                            <div class="col-1" style="width: 3px;">:</div>
                            <div class="col"><?php echo htmlspecialchars($user["phone_number"]) ?> </div>
                        </div>
                        <div class="row" data-aos="flip-right" data-aos-duration="2000">
                            <div class="col-1 label">Address</div>
                            <div class="col-1" style="width: 3px;">:</div>
                            <div class="col"><?php echo htmlspecialchars($user["address"]) ?></div>
                        </div>

                    </div>

                </div>
                <div class="col">
                <!-- <h3 class="card-title text-uppercase text-light text-center"><b>Action</b></h3> -->
                    <div class="stats p-1">
                        <a href="profileedit-page.php" class="my-2 w-100 btn btn-outline-info edit"><b>Edit Profile</b></a>
                        <a href="changepassword-page.php" class="my-2 w-100 btn btn-outline-warning change"><b>Change Password</b></a> 
                        <a href="deleteaccount-page.php" class="my-2 w-100 btn btn-outline-danger delete"><b>Delete Account</b></a>
                        <a class="btn btn-outline-success w-100 my-2" href="index.php"><b>Back</b></a>
                    </div>
                </div>

                <!-- <div class="col-5">
                    <h1 class="card-title text-uppercase text-light"><b>RECENT MOVIES</b></h1>
                </div> -->
            </div>
            <hr class="border-5 bg-light shadow-lg">
            <div class="row" style="overflow-y: auto; height: 400px;">
                <table class="table table-dark table-striped" >
                    <thead>
                        <th>Order ID</th>
                        <th>Movie</th>
                        <th>Seat</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>       
                    </thead>
                    <tbody >
                        <?php if(count($historys)):?>
                        <?php foreach ($historys as $history) : ?>
                            <tr>
                                <td><?php echo $history["tiket_id"] ?></td>
                                <td><?php echo $history["movie_name"] ?></td>
                                <td><?php echo $history["fk_kursi_id"] ?></td>
                                <td><?php echo $history["date"] ?></td>
                                <td><?php echo $history["jam_penayangan"] ?></td>
                                <td><?php echo $history["price"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else:?>
                            <tr>
                                <td colspan="6" class="text-center text-danger h1">No History</td>
                            </tr>
                        <?php endif;?>
                    </tbody>
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
    </div>
</body>

</html>