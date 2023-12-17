<?php
session_start();


require "database.php";
if (isset($_SESSION["login"])) {

    $data = $_SESSION["username"];

    $sql = "SELECT * FROM customer WHERE username = '$data'";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $guessUser = false;
} else {
    header("Location: signin-page.php");
}


if (isset($_POST['submit']) && isset($_POST['select_ticket'])) {
    $theatre = $_POST["theatre"];
    $theatres = query("SELECT theatre_id from data_theatre where theatre_name = '$theatre'");
    $theatre_id = $theatres[0]["theatre_id"];
    var_dump($theatre_id);
    
    $movie_id = $_POST["movie_id"];
    
    $maxTicket = $_POST['select_ticket'];
    // $sql = "SELECT "

    if ($maxTicket > 10 || $maxTicket < 1) {
        header("Location: upcomingdetail.php?movie_id=$movie_id&err=1");
    }
    else if ($maxTicket > availableSeat(1, $theatre_id)) {
        header("Location: upcomingdetail.php?movie_id=$movie_id&err=2");
    }
    
    $movies = query("SELECT * FROM movie WHERE movie_id = $movie_id");
    $name = $movies[0]["movie_name"];
  
    $time = $_POST["time"];
    $date = $_POST["date"];

    $sql = "SELECT * FROM detail_penayangan ds JOIN movie m ON (m.movie_id= ds.fk_movie_id) JOIN data_theatre t ON (t.theatre_id = ds.fk_theatre_id) JOIN schedule_hours s ON (ds.detail_penayangan_id = s.fk_detail_penayangan_id) WHERE fk_movie_id = $movie_id and fk_theatre_id = $theatre_id and jam_penayangan = '$time'";
    $result = $mysqli->query($sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    $theatre_id = $rows[0]["fk_theatre_id"];

    $harga = $rows[0]["harga_tiket"];
    // $date = $rows[0]["start_date"];
    $sql2 = "SELECT diagram_kursi FROM diagran_kursi WHERE fk_theatre_id = $theatre_id";
    $result2 = $mysqli->query($sql2);
    $rows2 = [];
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $rows2[] = $row2;
    }
    $diagram_kursi = $rows2[0]["diagram_kursi"];
} else {

    header("Location: index.php");
}


$host = "localhost";
$username = "root";
$password = "";
$dbname = "pcinemau";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function getSeatStatus($seatId ,$conn)
{
    global $theatre_id;
    global $diagram_kursi;
    $sql = "SELECT status FROM seat WHERE fusion_id = '$theatre_id-$diagram_kursi-$seatId'";
    var_dump($theatre_id."-".$diagram_kursi ."-".$seatId);
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['status'];
    }

    return 0;
}
$seatStatus = array(
    'A1' => getSeatStatus('A1', $conn),
    'A2' => getSeatStatus('A2', $conn),
    'A3' => getSeatStatus('A3', $conn),
    'A4' => getSeatStatus('A4', $conn),
    'A5' => getSeatStatus('A5', $conn),
    'A6' => getSeatStatus('A6', $conn),
    'A7' => getSeatStatus('A7', $conn),
    'B1' => getSeatStatus('B1', $conn),
    'B2' => getSeatStatus('B2', $conn),
    'B3' => getSeatStatus('B3', $conn),
    'B4' => getSeatStatus('B4', $conn),
    'B5' => getSeatStatus('B5', $conn),
    'B6' => getSeatStatus('B6', $conn),
    'B7' => getSeatStatus('B7', $conn),
    'C1' => getSeatStatus('C1', $conn),
    'C2' => getSeatStatus('C2', $conn),
    'C3' => getSeatStatus('C3', $conn),
    'C4' => getSeatStatus('C4', $conn),
    'C5' => getSeatStatus('C5', $conn),
    'C6' => getSeatStatus('C6', $conn),
    'C7' => getSeatStatus('C7', $conn),
    'D1' => getSeatStatus('D1', $conn),
    'D2' => getSeatStatus('D2', $conn),
    'D3' => getSeatStatus('D3', $conn),
    'D4' => getSeatStatus('D4', $conn),
    'D5' => getSeatStatus('D5', $conn),
    'D6' => getSeatStatus('D6', $conn),
    'D7' => getSeatStatus('D7', $conn),
    'D8' => getSeatStatus('D8', $conn),
);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once "../Partials/header.php" ?>
    <!-- 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> -->
    <script>
        $(document).ready(function() {
            let ticketCount = 0;
            let maxTicket = <?= $maxTicket ?>; //set dari halaman beli tiket
            let initialPrice = <?= $harga ?>; //set dari database
            let movieDate = new Date("<?= $date ?>"); //set dari database
            let selectedSeats = [];
            let movieTitle = "<?= $name ?>"; //ambil dari database
            let table = document.getElementById("seatTable"); //kupanggil table nya
            let data = table.getElementsByTagName('td'); //set kursi supaya ga satu2
            $(".jumlahTiket").html(ticketCount);
            $("#maxTicket").html(maxTicket)
            $(".title").html(movieTitle);
            $(".tanggalTayang").html(movieDate.getMonth() + 1 + "-" + movieDate.getDate() + "-" + movieDate.getFullYear());
            for (let i = 0; i < data.length; i++) {
                data[i].addEventListener('click', function() {
                    if ($(data[i]).hasClass("disabled-seat")) {
                        disable();
                    } /*if already sold td disabled*/
                    if ($(data[i]).hasClass("selected-seat")) {
                        ticketCount--;
                        $(".jumlahTiket").html(ticketCount);
                        $(data[i]).removeClass("selected-seat");
                        selectedSeats.splice(selectedSeats.indexOf(data[i].id), 1);
                    } else {
                        if (ticketCount < maxTicket) {
                            ticketCount++;
                            $(".jumlahTiket").html(ticketCount);
                            $(data[i]).addClass("selected-seat");
                            selectedSeats.push(data[i].id);
                        }
                    }
                    price = ticketCount * initialPrice;
                    $(".hargaTiket").html(price);
                    $("#selectedSeat").html(selectedSeats.join(", "));
                });
            }
            $("#confirmSeat").click(function(e) {
                e.preventDefault();
                if (ticketCount < maxTicket) {
                    $("#warningToast").show();
                } else {
                    $("#confirmModal").fadeIn("slow", function() {
                        $("#confirmModal").show();
                    });
                }

            });
            $(".modalCloseButton").click(function(e) {
                $("#confirmModal").fadeOut("slow", function() {
                    $(this).hide();
                });
            });
            $("#toastCloseButton").click(function() {
                console.log((".tanggalTayang").html());
                $("#warningToast").hide();

            });
            $(".strongConfirmButton").click(function() {
                for (let i = 0; i < data.length; i++) {
                    if ($(data[i]).hasClass("selected-seat")) {
                        $(data[i]).removeClass("selected-seat");
                        $(data[i]).addClass("disabled-seat");
                    }
                }
                $("#confirmModal").hide();
                ticketCount = 0; //direset ke 0
                $(".jumlahTiket").html(ticketCount); //diset ke posisi awal
                price = ticketCount * initialPrice;
                $(".hargaTiket").html(price); //diset ke posisi awal
                var seatsToSend = selectedSeats.slice();
                selectedSeats.splice(0, selectedSeats.length); // kosongkan array
                $("#selectedSeat").html(""); //dihilangkan tulisan yang ada dimodal
                console.log('Seats to send:', seatsToSend);
                $.ajax({
                    type: 'POST',
                    url: 'updateSeats.php',
                    data: {
                        user: '<?=$data?>',
                        movie_id : <?=$movie_id?>,
                        theatre_id: <?=$theatre_id?>,
                        diagram_kursi: <?=$diagram_kursi?>,
                        price: initialPrice,
                        ticketCount: $(".jumlahTiket").html(),
                        date : $(".tanggalTayang").html(),
                        selectedSeats: seatsToSend,
                        time : $(".waktuTayang").html()
                        
                    },
                    // dataType: 'json',
                    success: function(data) {
                        console.log('AJAX request success: ' + data);
                        if (data == 1){
                            window.location.href = "index.php?confirmP="+data;
                        }

                        // if (response.status === 'success') {
                        //     console.log('Seats updated successfully');
                        // } else {
                        //     console.error('Error updating seats: ' + response.message);
                        // }
                    },
                    error: function(data) {
                        // console.error('AJAX request failed: ' + error);
                        console.log(data);
                        if (data == 0){
                            window.location.href = "index.php?confirmP="+data;
                        }


                        // xhr, status, error
                    }
                });
            });
        });
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;700;800&family=Press+Start+2P&display=swap" rel="stylesheet">

    <style>
        /* body::before {
            content: '';
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            background-image: url("https://th.bing.com/th/id/OIG.fdZXYBIfHm2gCahikLC2?w=1024&h=1024&rs=1&pid=ImgDetMain");
            filter: opacity(50%);
        }

        .modal::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: black;
            filter: opacity(60%);

        } */

        @keyframes animate {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100%);
            }
        }

        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');

        .selected-seat {
            background-color: rgb(244, 255, 158) !important;
            color: black !important;
        }

        .disabled-seat {
            background-color: rgb(224, 95, 86) !important;
            color: white;
        }

        /* berfungsi sebagai toogle */
        * {
            font-family: 'Quicksand', sans-serif;
        }

        /* .onPage::first-letter {
            font-size: 50px !important;
        } */

        section {
            height: 100vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            #legend table {
                display: none !important;
            }
        }

        .modal-content::before {
            background-image: url("data:image;base64,<?= getMovie($movie_id) ?>");
            content: '';
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            filter: blur(5px);

        }

        .modal-content {
            position: relative;
            z-index: 1;
            text-shadow: 2px 2px 8px #000000;
            font-weight: bold;
        }

        .seatA td {
            background-color: rgb(26, 195, 86);
            color: white;
            border-width: 8.5px;
        }

        .seatB td {
            background-color: rgb(26, 195, 86);
            color: white;
            border-width: 8.5px;
        }

        .seatC td {
            background-color: rgb(26, 195, 86);
            color: white;
            border-width: 8.5px;
        }

        nav {
            background-color: rgb(10, 99, 140);
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

        .image-container {
            position: relative;
            width: 50%;
            padding-top: 66.6%;
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
    </style>

    <link rel="stylesheet" href="../Partials/general.css">
    <script src="../Partials/autoHoverBG.js"></script>
</head>

<body style="background-color:black">

    <section></section>
    <div class="bg-mid"></div>

    <!-- <div class="content"> -->

    <div id="confirmModal" class="modal" tabindex="-1" style="color:white;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">Please check your ticket order</h5>
                    <button type="button" class="modalCloseButton btn-close border-1" style="background:none; color:white" data-bs-dismiss="modal" aria-label="Close">
                        <!-- <span aria-hidden="true">&times;</span>
                     -->
                        <i class="bi bi-x-square-fill"></i>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center text-center align-content-center row" style="color:white">
                    <h3><span class=" title text-uppercase"></span></h3>
                    <div class="image-container">
                        <img src="data:image;base64,<?= getMovie($movie_id) ?>" class="img-thumbnail" style="display: block;">

                    </div>
                    <h4 class="mt-2">Checkout Details</h4>

                    <!-- <ul class="nav nav-tabs"> -->
                    <ul class="nav nav-tabs justify-content-center">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#date">Date</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seat">Seat</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ticket">Ticket</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#price">Price</a></li>
                    </ul>

                    <!-- </ul> -->

                    <div class="tab-content">
                        <div id="date" class="tab-pane fade in active show">
                            <h6 class="pt-2">Date</h6>
                            <p class="tanggalTayang blockquote"></p>
                        </div>
                        <div id="seat" class="tab-pane fade">
                            <h6 class="pt-2">Selected Seat</h6>
                            <p id="selectedSeat" class="blockquote"></p>
                        </div>
                        <div id="ticket" class="tab-pane fade ">
                            <h6 class="pt-2">Ticket Amount</h6>
                            <p class="jumlahTiket blockquote"></p>
                        </div>
                        <div id="price" class="tab-pane fade">
                            <h6 class="pt-2">Total Price</h6>
                            <p class="hargaTiket blockquote"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    
                    <button type="button" class="modalCloseButton btn btn-secondary" style="min-width: 30%;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="strongConfirmButton btn btn-dark" style="min-width: 30%;">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="warningToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="https://flyclipart.com/thumb2/small-warning-icon-icons-png-460175.png" class="rounded me-2" alt="..." style="width:1rem;">
                <strong class="me-auto">Warning</strong>
                <small>Just now</small>
                <button id="toastCloseButton" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Please select more seat!
            </div>
        </div>
    </div>


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
                    <form style="padding-right: 10px;">
                        <a href="upcomingdetail.php?movie_id=<?= $movie_id ?>" class="btn btn-outline-danger" type="Cancel" style="color:rgb(244, 205, 205)">Cancel</a>
                    </form>
                </div>
            </div>
        </nav>
        <!-- <nav class="navbar sticky-top">
            <div class="navbar-brand" style="padding-left: 10px; color:white"><strong>PCinemaU</strong></div>
            <form style="padding-right: 10px;">
                <button class="btn btn-outline-danger" type="Cancel" style="color:rgb(244, 205, 205)">Cancel</button>
            </form>
        </nav> -->
        <!-- <section> -->
        <div class="d-flex justify-content-center align-content-center flex-column h-100">
            <div class="container-fluid  text-center text-light mt-3">
                <h1 class="display-6 text-uppercase title text-warning" style="font-family: League Spartan, Verdana, Geneva, Tahoma, sans-serif;"></h1>
                <h5><span class="namaTheater"><span><strong> <?= $theatre ?></strong></span> - </span><strong><?= $diagram_kursi ?></strong></h5>
                <strong>Date :</strong> <span class="tanggalTayang h-6">12-10-2023</span> | <strong>Time :</strong> <span class="waktuTayang"><?= $time ?></span> <br>
                <strong>Tickets :</strong> <span class="jumlahTiket h-6"></span>/<span id="maxTicket"></span>, <strong>Total :</strong> Rp. <span class="hargaTiket">0</span> <br>
                <hr>
            </div>
            <div id="legend" class="container-fluid mt-2">
                <table class="table table-bordered d-flex justify-content-center" style="border-color:black">
                    <tr class="">
                        <td class="" style="background-color:rgb(26, 195, 86); color:white; ">XX</td>
                        <td class="" style="background-color:black; color:white; min-width: 90px;">Available</td>
                        <td class="" style="background-color:rgb(244, 255, 158);">XX</td>
                        <td class="" style="background-color:black; color:white; min-width: 90px;">Your Seat</td>
                        <td class="" style="background-color:rgb(224,95,86); color:white">XX</td>
                        <td class="" style="background-color:black; color:white; min-width: 90px;">Sold</td>
                    </tr>
                </table>
            </div>
            <div class="table-responsive d-flex justify-content-center mt-0 mb-5">
                <table id="seatTable" class="table table-bordered table-hover d-flex justify-content-center pb-5 mb-5" style="border-color:black;">
                    <tr>
                        <th colspan="9" class="text-center" style="background-color: rgb(40, 135, 40); color:white; border-width:8.5px;">Screen Area </th>
                    </tr>
                    <tr style="border-width: 8.5px;">
                        <th colspan="6" style="background-color: rgb(216, 215, 215);border-style:none;"> </th>
                        <th rowspan="5" style="background-color: rgb(216, 215, 215);border-style:none;"> </th>
                        <th colspan="2" class="text-center" style="background-color:rgb(224, 95, 86); border-width:8.5px; color:white;">DOOR</th>
                    </tr>
                    <tr class="seatA">
                        <td id="A1" class="<?php echo ($seatStatus['A1'] == 1) ? 'disabled-seat' : ''; ?>">A1</td>
                        <td id="A2" class="<?php echo ($seatStatus['A2'] == 1) ? 'disabled-seat' : ''; ?>">A2</td>
                        <td id="A3" class="<?php echo ($seatStatus['A3'] == 1) ? 'disabled-seat' : ''; ?>">A3</td>
                        <td id="A4" class="<?php echo ($seatStatus['A4'] == 1) ? 'disabled-seat' : ''; ?>">A4</td>
                        <td id="A5" class="<?php echo ($seatStatus['A5'] == 1) ? 'disabled-seat' : ''; ?>">A5</td>
                        <td id="A6" class="<?php echo ($seatStatus['A6'] == 1) ? 'disabled-seat' : ''; ?>">A6</td>
                        <td id="A7" class="<?php echo ($seatStatus['A7'] == 1) ? 'disabled-seat' : ''; ?>">A7</td>
                    </tr>
                    <tr class="seatB">
                        <td id="B1" class="<?php echo ($seatStatus['B1'] == 1) ? 'disabled-seat' : ''; ?>">B1</td>
                        <td id="B2" class="<?php echo ($seatStatus['B2'] == 1) ? 'disabled-seat' : ''; ?>">B2</td>
                        <td id="B3" class="<?php echo ($seatStatus['B3'] == 1) ? 'disabled-seat' : ''; ?>">B3</td>
                        <td id="B4" class="<?php echo ($seatStatus['B4'] == 1) ? 'disabled-seat' : ''; ?>">B4</td>
                        <td id="B5" class="<?php echo ($seatStatus['B5'] == 1) ? 'disabled-seat' : ''; ?>">B5</td>
                        <td id="B6" class="<?php echo ($seatStatus['B6'] == 1) ? 'disabled-seat' : ''; ?>">B6</td>
                        <td id="B7" class="<?php echo ($seatStatus['B7'] == 1) ? 'disabled-seat' : ''; ?>">B7</td>
                    </tr>
                    <tr class="seatC">
                        <td id="C1" class="<?php echo ($seatStatus['C1'] == 1) ? 'disabled-seat' : ''; ?>">C1</td>
                        <td id="C2" class="<?php echo ($seatStatus['C2'] == 1) ? 'disabled-seat' : ''; ?>">C2</td>
                        <td id="C3" class="<?php echo ($seatStatus['C3'] == 1) ? 'disabled-seat' : ''; ?>">C3</td>
                        <td id="C4" class="<?php echo ($seatStatus['C4'] == 1) ? 'disabled-seat' : ''; ?>">C4</td>
                        <td id="C5" class="<?php echo ($seatStatus['C5'] == 1) ? 'disabled-seat' : ''; ?>">C5</td>
                        <td id="C6" class="<?php echo ($seatStatus['C6'] == 1) ? 'disabled-seat' : ''; ?>">C6</td>
                        <td id="C7" class="<?php echo ($seatStatus['C7'] == 1) ? 'disabled-seat' : ''; ?>">C7</td>
                    </tr>
                    <tr class="seatB">
                        <td id="D1" class="<?php echo ($seatStatus['D1'] == 1) ? 'disabled-seat' : ''; ?>">D1</td>
                        <td id="D2" class="<?php echo ($seatStatus['D2'] == 1) ? 'disabled-seat' : ''; ?>">D2</td>
                        <td id="D3" class="<?php echo ($seatStatus['D3'] == 1) ? 'disabled-seat' : ''; ?>">D3</td>
                        <td id="D4" class="<?php echo ($seatStatus['D4'] == 1) ? 'disabled-seat' : ''; ?>">D4</td>
                        <td id="D5" class="<?php echo ($seatStatus['D5'] == 1) ? 'disabled-seat' : ''; ?>">D5</td>
                        <td id="D6" class="<?php echo ($seatStatus['D6'] == 1) ? 'disabled-seat' : ''; ?>">D6</td>
                        <td id="D7" class="<?php echo ($seatStatus['D7'] == 1) ? 'disabled-seat' : ''; ?>">D7</td>
                        <td id="D8" class="<?php echo ($seatStatus['D8'] == 1) ? 'disabled-seat' : ''; ?>">D8</td>
                    </tr>
                </table>
            </div>
        </div>

        <nav class="navbar fixed-bottom bg-dark mt-5">
            <div class="container-fluid d-flex justify-content-center">
                <form>
                    <button id="confirmSeat" class="btn btn-outline-success" type="Success" style="color:rgb(183, 248, 183)" data-toggle="modal" data-target="#confirmModal">Confirm Seat Placement</button>
                </form>
            </div>
        </nav>

    </div>
</body>

</html>