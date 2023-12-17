<?php
require '../signup-in page/database.php';


if (isset($_GET['genre'])) {
    $genre = $_GET['genre'];
    $nowPlaying = query("SELECT * from movie where genre like '%$genre%'");

} else {
    $nowPlaying = query("SELECT * from movie where genre like '%%'");
}


echo `
<div class='row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-2 mb-5'>`;

foreach ($nowPlaying as $movie) : ?>
    <?php if($movie['status'] == 1):
    echo "<div class='col'>

        <!-- <div class='card'>
    <div ></div> -->
        <div class='card movie-card h-100 ' data-aos='zoom-in-up' data-aos-delay='300' data-aos-duration='1000'>
            <a href='upcomingdetail.php?movie_id=".$movie['movie_id']."class='text-decoration-none text-dark'>
                <div class='image-container'>
                    <img class='card-img-top' style='object-fit: cover ;' src='data:image;base64,".getMovie($movie['movie_id'])." alt='".$movie['movie_name']."'>

                </div>
            </a>
            <a href='upcomingdetail.php?movie_id=".$movie['movie_id']."' class='text-decoration-none text-dark'>

                <div class='card-body'>

                    <!-- <p class='card-text'>Action, Adventure, Fantasy, Sci-fi</p> -->
                    <h6 class='card-title text-center text-uppercase'><b>".$movie['movie_name']."</b></h6>

                </div>
            </a>
        </div>
        <!-- </div> -->
    </div>";
     endif;
endforeach; 
?>
