<?php
session_start();
require_once('adminHandler.php');
require_once('movieHandler.php');

if (!isset($_SESSION['user'])) {
    header("Location: adminLogin.php");
    exit();
}

function validatePhoneNumber($phoneNumber) {
    // Remove non-numeric characters from the phone number
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Check if the phone number has a valid length (e.g., 10 digits for a basic validation)
    if (strlen($phoneNumber) >= 10) {
        return true;
    } else {
        return false;
    }
}

function validData($data) {
    return trim(stripslashes($data));

}

$adminHandler = new AdminHandler();
$movieHandler = new MovieHandler();
if (isset($_POST['add_submit'])) {
    if (isset($_POST['NIP']) && $_POST['nama'] && $_POST['password'] && $_POST['kontak'] && $_POST['fk_location_id'] && $_POST['confirmPassword']) {
        $NIP = $_POST['NIP'];
        $nama = $_POST['nama'];
        $password = $_POST['password'];
        $kontak = $_POST['kontak'];
        $fk_location_id = $_POST['fk_location_id'];
        $confirmPassword = $_POST['confirmPassword'];
        $condition = $adminHandler->addAdmin($NIP, $password, $nama, $kontak, $fk_location_id);
        if ($condition == false) {
            echo "<script>alert('Error adding admin');</script>";
        } else if ($confirmPassword != $password) {
            echo "<script>alert('Confirm Password and Password don't match');</script>";
        } else {
            echo "<script>alert('Success');</script>";
        }
    } else {
        echo "<script>alert('Don\\'t leave the input field empty');</script>"; // Escaped the single quote
    }
} else if (isset($_POST['edit_submit'])) {
    // Ensure all required fields are set
    if (isset($_POST['edit_NIP'], $_POST['edit_nama'], $_POST['new_password'], $_POST['edit_kontak'], $_POST['old_password'])) {
        $NIP = $_POST['edit_NIP'];
        $nama = $_POST['edit_nama'];
        $old_password = $_POST['old_password'];
        $kontak = $_POST['edit_kontak'];
        $new_password = $_POST['new_password'];


        $condition = $adminHandler->editAdmin($old_password, $new_password, $nama, $NIP, $kontak);

        if ($condition) {
            echo "<script>alert('Success');</script>";
        } else {
            echo "<script>alert('Error editing admin');</script>";
        }
    } else {
        echo "<script>alert('Don\\'t leave the input field empty');</script>";
    }
} else if (isset($_POST['add_movie_submit'])) {
    if (isset($_POST['movie_name']) && isset($_POST['movie_length']) && isset($_POST['movie_image']) && isset($_POST['trailer']) && isset($_POST['genre']) && isset($_POST['produser']) && isset($_POST['cast']) && isset($_POST['sutradara']) && isset($_POST['penulis']) && isset($_POST['status']) && isset($_POST['fk_supplier_id']) && isset($_POST['movie_name']) && isset($_POST['movie_details'])) {
        $movie_name = $_POST['movie_name'];
        $movie_length = $_POST['movie_length'];
        $movie_image = $_POST['movie_image'];
        $trailer  = $_POST['trailer'];
        $genre = $_POST['genre'];
        $produser = $_POST['produser'];
        $cast = $_POST['cast'];
        $sutradara = $_POST['sutradara'];
        $penulis = $_POST['penulis'];
        $status = $_POST['status'];
        $fk_supplier_id = $_POST['fk_supplier_id'];
        $movie_id = $_POST['movie_id'];
        $movie_details = $_POST['movie_details'];

        $condition = $movieHandler->addMovie($movie_id, $movie_name, $genre, $trailer, $fk_supplier_id, $movie_length, $movie_details, $produser, $sutradara, $penulis, $cast, $movie_image, $status);
        if ($condition) {
            echo "<script>alert('Error');</script>";
        } else {
            echo "<script>alert('Success');</script>";
        }
    } else {
        echo "<script>alert('Don\\'t leave the input field empty');</script>"; // Escaped the single quote
    }
} else if (isset($_POST['delete_movie_submit'])) {
    if (isset($_POST['movie_name']) && isset($_POST['movie_id']) && (!empty($_POST['movie_name']) || !empty($_POST['movie_name']))) {
        $movie_id = $_POST['movie_id'];
        $movie_name = $_POST['movie_name'];
        $condition = $movieHandler->deleteMovie($movie_id, $movie_name);
        if ($condition) {
            echo "<script>alert('Success');</script>";
        } else {
            echo "<script>alert('Error');</script>";
        }
    } else {
        echo "<script>alert('Don\\'t leave the input field empty');</script>"; // Escaped the single quote
    }
}
// else if(isset($_POST['reset_submit'])){
//     $condition = $movieHandler->resetSeat();
//     if($condition == false){
//         echo "<script>alert('Error reseting seat');</script>";
//     } else{
//         echo "<script>alert('Success');</script>";

//     }
// }
else if (isset($_POST['logOut'])) {
    session_start();
    session_unset();
    session_destroy();
    header('Location:adminLogin.php');
}


else if (isset($_POST['add_theatre_submit'])) {
    if (isset($_POST['theatre_name']) && isset($_POST["phone"]) && isset($_POST['location'])) {
        $theatre_name = validData(strtoupper(htmlspecialchars($_POST['theatre_name'])));
        $phone = htmlspecialchars($_POST['phone']);
        $location = validData(strtoupper(htmlspecialchars($_POST['location'])));
        $condition = $movieHandler->addTheatre($theatre_name, $phone, $location);
        if ($condition) {
            echo "<script>alert('Success');</script>";
        } else {
            echo "<script>alert('Error');</script>";
        }
    }
    else {
        echo "<script>alert('Don\\'t leave the input field empty');</script>"; // Escaped the single quote
    }
}


else if (isset($_POST['addSchedule'])) {
    if (isset($_POST['movie_id']) && isset($_POST['theatre_id']) && isset($_POST['startD']) && isset($_POST['endD']) && isset($_POST['price']) && isset($_POST['startT'])) {
        $movie_id = $_POST['movie_id'];
        $theatre_id = $_POST['theatre_id'];
        $start_date = $_POST['startD'];
        $end_date = $_POST['endD'];
        $price = $_POST['price'];
        $startT = $_POST['startT'];
        $startT = date("H:i:s", strtotime($_POST['startT']));

        $condition = $movieHandler->addSchedule($movie_id, $theatre_id, $start_date, $end_date, $price, $startT);
        if ($condition) {
            echo "<script>alert('Success');</script>";
        } else {
            echo "<script>alert('Error');</script>";
        }
    }
    else {
        echo "<script>alert('Don\\'t leave the input field empty');</script>"; // Escaped the single quote
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap">
    <script>
        function showTransaction(str) {
            if (str == "") {
                document.getElementById("showHere").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("showHere").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getTransaction.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }

        body {
            background-size: 100px 100px;
            background-color: rgb(14, 13, 13);
            background-image: linear-gradient(to right, rgb(231, 179, 46) 2px, transparent 2px), linear-gradient(to bottom, rgb(231, 179, 46) 2px, transparent 2px);
            animation: backgroundAnimation 5s infinite linear;
        }

        @keyframes backgroundAnimation {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100px 100px;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.nav-item').click(function() {
                // Remove active class from all nav items
                $('.nav-item a').removeClass('bg-dark rounded-top border border-dark text-warning');
                $('.nav-item a').addClass('text-warning-emphasis');
                // Add active class to the clicked nav item
                $(this).find('a').removeClass('text-warning-emphasis');
                $(this).find('a').addClass('bg-dark rounded-top border border-dark text-warning');

                // Hide all card bodies
                $('.navigation').addClass('d-none');

                // Show the corresponding card body based on the clicked nav item
                var targetId = $(this).children('a').attr('href');
                $(targetId).removeClass('d-none');
            });
            $('#addAdminButton').click(function() {
                $('.menuContext').addClass('d-none');
                $('#addAdminMenuContext').removeClass('d-none');
            });
            $('#editAdminButton').click(function() {
                $('.menuContext').addClass('d-none');
                $('#editAdminMenuContext').removeClass('d-none');
            });
            $('#addMovieButton').click(function() {
                $('.menuContext').addClass('d-none');
                $('#addMovieMenuContext').removeClass('d-none');
            });
            $('#deleteMovieButton').click(function() {
                $('.menuContext').addClass('d-none');
                $('#deleteMovieMenuContext').removeClass('d-none');
            });
            $('#transactionButton').click(function() {
                $('.menuContext').addClass('d-none');
                $('#transactionContext').removeClass('d-none');
            });

            $('#detailTayang').click(function() {
                $('.menuContext').addClass('d-none');
                $('#detailContext').removeClass('d-none');
            });

            $('#addTheatre').click(function() {
                $('.menuContext').addClass('d-none');
                $('#addTheatreContext').removeClass('d-none');
            });
            // $('#resetSeatButton').click(function() {
            //     $('.menuContext').addClass('d-none');
            //     $('#resetSeatContext').removeClass('d-none');
            // });
        });
    </script>

    <script src="../Partials/autoHoverBG.js"></script>
    <link rel="stylesheet" href="../Partials/general.css">
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
    </style>
</head>

<body style="overflow-x: hidden;">
    <section>

    </section>
    <div class="bg-mid">
    </div>

    <div class="content">
        <div class="container-fluid">
            <div>
                <H1 class="text-warning text-center p-5 text-uppercase">Hello, <?php echo $_SESSION['user'] ?></H1>
            </div>
            <div class="card text-center bg-warning">
                <div class="card-header bg-black text-warning">
                    <ul class="nav nav-tabs card-header-tabs text-warning">
                        <li class="nav-item">
                            <a class="nav-link bg-dark rounded-top border text-warning" href="#addAdminMenu">Add Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#editAdminMenu">Edit Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#addMovieMenu">Add Movie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#addTheatreMenu">Add Theatre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#detailTayangMenu">Add Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#deleteMovieMenu">Delete Movie</a>
                        </li>
                        <!-- <li class="nav-item">
                        <a class="nav-link text-warning-emphasis" href="#resetSeatMenu">Reset Seat</a>
                    </li> -->
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#transactionMenu">See Transaction</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-warning-emphasis" href="#logOut">Logout</a>
                        </li>

                    </ul>
                </div>
                <div id="addAdminMenu" class="card-body navigation bg-dark text-warning">
                    <h5 class="card-title">Add Admin</h5>
                    <p class="card-text">Make Sure you have the privileges to Add Admin</p>
                    <a href="#" id="addAdminButton" class="btn btn-dark text-warning border border-warning">Continue</a>
                </div>
                <div id="editAdminMenu" class="card-body navigation bg-dark text-warning d-none ">
                    <h5 class="card-title">Edit Admin</h5>
                    <p class="card-text">Make Sure you have the privileges to Edit Admin</p>
                    <a href="#" id="editAdminButton" class="btn btn-dark text-warning border border-warning">Continue</a>
                </div>
                <div id="addMovieMenu" class="card-body navigation bg-dark text-warning d-none">
                    <h5 class="card-title">Add Movie</h5>
                    <p class="card-text">The movie added will be posted on the now playing page</p>
                    <a href="#" id="addMovieButton" class="btn btn-dark text-warning border border-warning">Continue</a>
                </div>
                <div id="addTheatreMenu" class="card-body navigation bg-dark text-warning d-none">
                    <h5 class="card-title">Add Theatre</h5>
                    <p class="card-text">The theatre added will be posted on the homepage</p>
                    <a href="#" id="addTheatre" class="btn btn-dark text-warning border border-warning">Continue</a>
                </div>
                <div id="detailTayangMenu" class="card-body navigation bg-dark text-warning d-none">
                    <h5 class="card-title">Add Movie Schedule</h5>
                    <p class="card-text">Add details about the screening of a film including location and time</p>
                    <a href="#" id="detailTayang" class="btn btn-dark text-warning border border-warning">Continue</a>
                </div>
                <div id="deleteMovieMenu" class="card-body navigation bg-dark text-warning d-none">
                    <h5 class="card-title">Remove Movie</h5>
                    <p class="card-text">Remove movie from the now playing page</p>
                    <a href="#" id="deleteMovieButton" class="btn btn-dark text-warning border border-warning">Continue</a>
                </div>
                <!-- <div id="resetSeatMenu" class="card-body navigation bg-dark text-warning d-none">
                <h5 class="card-title">Reset Seat</h5>
                <p class="card-text">Reset seat everytime show's done</p>
                <a href="#" id ="resetSeatButton" class="btn btn-dark text-warning border border-warning">Continue</a>
            </div> -->
                <div id="transactionMenu" class="card-body navigation bg-dark text-warning d-none">
                    <h5 class="card-title">Transaction History</h5>
                    <p class="card-text">See customer's transaction history</p>
                    <button id="transactionButton" class="btn btn-dark text-warning border border-warning">Continue</button>
                </div>
                <div id="logOut" class="card-body navigation bg-dark text-warning d-none">
                    <h5 class="card-title">LogOut</h5>
                    <p class="card-text">Are You Sure?</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <button name="logOut" id="logOutButton" class="btn btn-dark text-warning border border-warning">Yes</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="addAdminMenuContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>Add New Admin</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-black">
                    Building Admin Profile Data
                </div>
                <div class="card-body">
                    <h5 class="card-title">Who Are You?</h5>
                    <p class="card-text">Please fill with correct data and information.</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: start;">
                        <div class="form-group text-warning">
                            <label>NIP</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="NIP" name="NIP">
                        </div>
                        <div class="form-group text-warning">
                            <label>Password</label>
                            <input class="form-control focus-ring focus-ring-warning" type="password" id="password" name="password">
                        </div>
                        <div class="form-group text-warning">
                            <label>Confirm Password</label>
                            <input class="form-control focus-ring focus-ring-warning" type="password" id="confirmPassword" name="confirmPassword">
                        </div>
                        <div class="form-group text-warning">
                            <label>Nama</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="nama" name="nama">
                        </div>
                        <div class="form-group text-warning">
                            <label>Kontak</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="kontak" name="kontak">
                        </div>
                        <div class="form-group text-warning">
                            <label>ID Lokasi Tugas</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="fk_location_id" name="fk_location_id">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="add_submit" id="add_submit">Confirm</button>
                </div>
                </form>
            </div>
        </div>
        <div id="editAdminMenuContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>Edit Admin</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-dark">
                    Edit your admin data
                </div>
                <div class="card-body">
                    <h5 class="card-title">Personalize your profile</h5>
                    <p class="card-text">You can't change your NIP and ID Lokasi Tugas.</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: start;">
                        <p class="card-text"><strong>Initial Data :</strong></p>
                        <div class="form-group text-warning">
                            <label>NIP</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="edit_NIP" name="edit_NIP">
                        </div>
                        <div class="form-group text-warning">
                            <label>Old Password</label>
                            <input class="form-control focus-ring focus-ring-warning" type="password" id="old_password" name="old_password">
                        </div>
                        <p class="card-text"><strong>Replacement Data : </strong></p>

                        <div class="form-group text-warning">
                            <label>New Password</label>
                            <input class="form-control focus-ring focus-ring-warning" type="password" id="new_password" name="new_password">
                        </div>
                        <div class="form-group text-warning">
                            <label>Nama</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="edit_nama" name="edit_nama">
                        </div>
                        <div class="form-group text-warning">
                            <label>Kontak</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="edit_kontak" name="edit_kontak">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="edit_submit" id="edit_submit">Confirm</button>
                </div>
                </form>
            </div>
        </div>
        <div id="addMovieMenuContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>Add New Movie</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-black">
                    Building Movie Data
                </div>
                <div class="card-body">
                    <h5 class="card-title">What's Playing?</h5>
                    <p class="card-text">Please fill with correct data and information.</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: start;">
                        <div class="form-group text-warning">
                            <label>Movie Name</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="add_movie_name" name="movie_name">
                        </div>
                        <div class="form-group text-warning">
                            <label>Duration</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="movie_length" name="movie_length">
                        </div>
                        <div class="form-group text-warning">
                            <label>Genre</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="genre" name="genre">
                        </div>
                        <div class="form-group text-warning">
                            <label>Trailer</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="trailer" name="trailer">
                        </div>
                        <div class="form-group text-warning">
                            <label>Supplier Id</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="fk_supplier_id" name="fk_supplier_id">
                        </div>
                        <div class="form-group text-warning">
                            <label>Synopsis</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="movie_details" name="movie_details">
                        </div>
                        <div class="form-group text-warning">
                            <label>Sutradara</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="sutradara" name="sutradara">
                        </div>
                        <div class="form-group text-warning">
                            <label>Producer</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="produser" name="produser">
                        </div>
                        <div class="form-group text-warning">
                            <label>Penulis</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="penulis" name="penulis">
                        </div>
                        <div class="form-group text-warning">
                            <label>Cast</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="cast" name="cast">
                        </div>
                        <div class="form-group text-warning">
                            <label>Movie Image</label>
                            <input class="form-control focus-ring focus-ring-warning" type="file" id="movie_image" name="movie_image">
                        </div>
                        <div class="form-group text-warning">
                            <label>Status</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="status" name="status">
                        </div>
                        <div class="form-group text-warning">
                            <label>Movie Id</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="add_movie_id" name="movie_id">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="add_movie_submit" id="add_movie_submit">Confirm</button>
                </div>
                </form>
            </div>
        </div>
        <div id="deleteMovieMenuContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>Delete Movie</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-dark">
                    Remove Movie
                </div>
                <div class="card-body">
                    <h5 class="card-title">Expired or Canceled Movie Data </h5>
                    <p class="card-text">Movie that has been deleted will be removed from now playing page, upcoming movies page, and database</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: start;">
                        <div class="form-group text-warning">
                            <label>Movie Id</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="movie_id" name="movie_id">
                        </div>
                        <div class="form-group text-warning">
                            <label>Movie Name</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="movie_name" name="movie_name">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="delete_movie_submit" id="delete_movie_submit">Confirm</button>
                </div>
                </form>
            </div>
        </div>
        <div id="transactionContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>See Transaction</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-dark">
                    Transaction Detail
                </div>
                <div class="card-body">
                    <h5 class="card-title">See Customer Transaction </h5>
                    <p class="card-text">All Customer Transaction will be listed here</p>
                    <form style="text-align: start;">
                        <div class="form-group text-warning">
                            <label>Customer Id</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="customer_id" name="customer_id">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="button" name="transaction_submit" id="submit" onclick="showTransaction($('#customer_id').val())">Confirm</button>
                </div>
                </form>
                <div id="showHere">

                </div>
            </div>
        </div>

        <div id="addTheatreContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>Add New Theatre</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-black">
                    Building Theatre Data
                </div>
                <div class="card-body">
                    <h5 class="card-title">Theatre Info</h5>
                    <p class="card-text">Please fill with correct data and information.</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: start;">
                        <div class="form-group text-warning">
                            <label>Location</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="location" name="location">
                        </div>
                        <div class="form-group text-warning">
                            <label>Theatre Name</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="theatre_name" name="theatre_name">
                        </div>
                        <div class="form-group text-warning">
                            <label>Phone Number</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="phone" name="phone">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="add_theatre_submit" id="add_theatre_submit">Confirm</button>
                </div>
                </form>
            </div>
        </div>



        <div id="detailContext" class="container-fluid d-none menuContext">
            <div class="text-warning">
                <h1>Add Schedule</h1>
            </div>
            <div class="card text-center text-warning bg-dark">
                <div class="card-header bg-warning text-black">
                    Schedule Details
                </div>
                <div class="card-body">
                    <h5 class="card-title">Schedule Info</h5>
                    <p class="card-text">Please fill with correct data and information.</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="text-align: start;">
                        <div class="form-group text-warning">
                            <label>Movie ID</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="movie_id" name="movie_id">
                        </div>
                        <div class="form-group text-warning">
                            <label>Theatre ID</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="theatre_id" name="theatre_id">
                        </div>
                        <div class="form-group text-warning">
                            <label>Price</label>
                            <input class="form-control focus-ring focus-ring-warning" type="text" id="price" name="price">
                        </div>
                        <div class="form-group text-warning">
                            <label>Start-Date</label>
                            <input class="form-control focus-ring focus-ring-warning" type="date" id="startD" name="startD">
                        </div>
                        <div class="form-group text-warning">
                            <label>End Date</label>
                            <input class="form-control focus-ring focus-ring-warning" type="date" id="endD" name="endD">
                        </div>
                        <div class="form-group text-warning">
                            <label>Start Time</label>
                            <input class="form-control focus-ring focus-ring-warning" type="time" id="startT" name="startT">
                        </div>
                </div>
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="addSchedule" id="addSchedule">Confirm</button>
                </div>
                </form>
            </div>
        </div>

    </div>





    <div id="resetSeatContext" class="container-fluid d-none menuContext">
        <div class="text-warning">
            <h1>Are You Sure?</h1>
        </div>
        <div class="card text-center text-warning bg-dark">
            <div class="card-header bg-warning text-dark">
                Confirmation
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="card-footer bg-warning">
                    <button class="btn btn-dark" type="submit" name="reset_submit" id="reset_submit">Confirm</button>
                </div>
            </form>
        </div>
    </div>



</body>

</html>