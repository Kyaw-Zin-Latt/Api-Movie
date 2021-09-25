<?php
require_once "core/base.php";
require_once "function.php";

$data = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
$nowPlayingMovies = json_decode($data);
$nowPlayingMoviesResult = $nowPlayingMovies->results;
$nowPlayingMoviesResultSlided = array_slice($nowPlayingMoviesResult,0,19);

$data = file_get_contents("https://api.themoviedb.org/3/tv/on_the_air?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
$popularTVShows = json_decode($data);
$popularTVShowsResult = $popularTVShows->results;

$data = file_get_contents("https://api.themoviedb.org/3/trending/all/day?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400");
$trendByDay = json_decode($data);
$trendByDayResults = $trendByDay->results;

$data = file_get_contents("https://api.themoviedb.org/3/trending/all/week?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400");
$trendByWeek = json_decode($data);
$trendByWeekResults = $trendByWeek->results;


?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
   content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Movie Project</title>
<link rel="stylesheet" href="<?php echo $url; ?>/assets/css/app.css">
<link rel="stylesheet" href="<?php echo $url; ?>/assets/css/style.css">
<link rel="stylesheet" href="<?php echo $url; ?>/assets/css/simplePagination.css">
<link rel="stylesheet" href="<?php echo $url; ?>/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="<?php echo $url; ?>/node_modules/image_hover/css/imagehover.min.css">
<link rel="stylesheet" href="<?php echo $url; ?>/node_modules/venobox/venobox/venobox.min.css">
<link rel="stylesheet" href="<?php echo $url; ?>/node_modules/slick/slick.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/node_modules/slick/slick-theme.css">

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include_once "components/navbar.php"; ?>

    </div>
</div>

<section class="home d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12 ">
                <div class="h-100">
                    <h1 class="text-white fw-bolder">Welcome.</h1>
                    <h3 class="text-light">Millions of movies, TV shows and people to discover. Explore now.</h3>
                </div>
                <form class="d-flex position-relative" method="post" action="<?php echo $url; ?>/search/search.php">
                    <input class="form-control rounded-pill" name="query" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary rounded-pill position-absolute" style="right: 0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row my-3">
<!--        what's popular start-->
        <div class="col-12">
            <div class="d-flex">
                <h3 class="me-3">What's Popular</h3>
                <ul class="nav nav-pills mb-3 border border-dark rounded-pill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#popularMovie" type="button" role="tab" aria-controls="popularMovie" aria-selected="true">On TV</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#popularTv" type="button" role="tab" aria-controls="popularTv" aria-selected="false">In Theaters</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="popularMovie" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row on-theater card-no-wrap overflow-scroll">
                        <?php foreach ($popularTVShowsResult as $row) { ?>
                            <div class="mb-3" style="width: 15.5%">

                                <div class="card h-100 rounded-3 ">
                                    <?php if (empty($row->poster_path)){ ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                                        <div class="d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 239px;">
                                            <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                        </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                            <img src="https://image.tmdb.org/t/p/w220_and_h330_face<?php echo $row->poster_path; ?>" class="rounded-top card-img-top" style="height: 239px; alt="">
                                        </a>
                                    <?php } ?>

                                    <div class="card-body position-relative pt-4">
                                        <!--                                    percentage circle start-->
                                        <div class="single-chart position-absolute" style="top: -35px; left: 5px">
                                            <svg viewBox="0 0 36 36" class="circular-chart
                                        <?php
                                            $votePercentage = numberFormat($row->vote_average);
                                            if ($votePercentage <= 40 && $votePercentage > 1) {
                                                echo "red";
                                            } elseif ($votePercentage < 70 && $votePercentage >= 40) {
                                                echo "orange";
                                            } elseif ($votePercentage >= 70) {
                                                echo "green";
                                            } elseif ($votePercentage = 1) {
                                                echo "";
                                            }

                                            ?>
                                        ">
                                                <path class="circle-bg"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <path class="circle"
                                                      stroke-dasharray="30, 100"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <text x="18" y="20.35" class="percentage"><?php echo numberFormat($row->vote_average) > 1 ? numberFormat($row->vote_average)."%" : "NR" ; ?></text>
                                            </svg>
                                        </div>
                                        <!--                                    percentage circle end-->
                                        <a href="" class="title text-decoration-none text-dark">
                                            <h6 class="card-title"><?php echo $row->original_name; ?></h6>
                                        </a>
                                        <p class="card-text text-black-50"><?php echo showDate($row->first_air_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="popularTv" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row on-theater card-no-wrap overflow-scroll">
                        <?php foreach ($nowPlayingMoviesResult as $row) { ?>
                            <div class="mb-3" style="width: 15.5%">

                                <div class="card h-100 rounded-3 ">
                                    <?php if (empty($row->poster_path)){ ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                                        <div class="d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 239px;">
                                            <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                        </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                            <img src="https://image.tmdb.org/t/p/w220_and_h330_face<?php echo $row->poster_path; ?>" class="rounded-top card-img-top" style="height: 239px; alt="">
                                        </a>
                                    <?php } ?>

                                    <div class="card-body position-relative pt-4">
                                        <!--                                    percentage circle start-->
                                        <div class="single-chart position-absolute" style="top: -35px; left: 5px">
                                            <svg viewBox="0 0 36 36" class="circular-chart
                                        <?php
                                            $votePercentage = numberFormat($row->vote_average);
                                            if ($votePercentage <= 40 && $votePercentage > 1) {
                                                echo "red";
                                            } elseif ($votePercentage < 70 && $votePercentage >= 40) {
                                                echo "orange";
                                            } elseif ($votePercentage >= 70) {
                                                echo "green";
                                            } elseif ($votePercentage = 1) {
                                                echo "";
                                            }

                                            ?>
                                        ">
                                                <path class="circle-bg"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <path class="circle"
                                                      stroke-dasharray="30, 100"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <text x="18" y="20.35" class="percentage"><?php echo numberFormat($row->vote_average) > 1 ? numberFormat($row->vote_average)."%" : "NR" ; ?></text>
                                            </svg>
                                        </div>
                                        <!--                                    percentage circle end-->
                                        <a href="" class="title text-decoration-none text-dark">
                                            <h6 class="card-title"><?php echo $row->title; ?></h6>
                                        </a>
                                        <p class="card-text text-black-50"><?php echo showDate($row->release_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<!--        what' popular end-->
        
<!--        trending start-->
        <div class="col-12 trending" style="background-image: url('assets/img/download.svg')">
            <div class="d-flex">
                <h3 class="me-3">Trending</h3>
                <ul class="nav nav-pills mb-3 border border-dark rounded-pill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#trendingByDay" type="button" role="tab" aria-controls="trendingByDay" aria-selected="true">Today</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#trendingByWeek" type="button" role="tab" aria-controls="trendingByWeek" aria-selected="false">This Week</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="trendingByDay" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row on-theater card-no-wrap overflow-scroll">
                        <?php foreach ($trendByDayResults as $row) { ?>
                            <div class="mb-3" style="width: 15.5%">

                                <div class="card h-100 rounded-3 ">
                                    <?php if (empty($row->poster_path)){ ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                                        <div class="d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 239px;">
                                            <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                        </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                            <img src="https://image.tmdb.org/t/p/w220_and_h330_face<?php echo $row->poster_path; ?>" class="rounded-top card-img-top" style="height: 239px; alt="">
                                        </a>
                                    <?php } ?>

                                    <div class="card-body position-relative pt-4">
                                        <!--                                    percentage circle start-->
                                        <div class="single-chart position-absolute" style="top: -35px; left: 5px">
                                            <svg viewBox="0 0 36 36" class="circular-chart
                                        <?php
                                            $votePercentage = numberFormat($row->vote_average);
                                            if ($votePercentage <= 40 && $votePercentage > 1) {
                                                echo "red";
                                            } elseif ($votePercentage < 70 && $votePercentage >= 40) {
                                                echo "orange";
                                            } elseif ($votePercentage >= 70) {
                                                echo "green";
                                            } elseif ($votePercentage = 1) {
                                                echo "";
                                            }

                                            ?>
                                        ">
                                                <path class="circle-bg"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <path class="circle"
                                                      stroke-dasharray="30, 100"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <text x="18" y="20.35" class="percentage"><?php echo numberFormat($row->vote_average) > 1 ? numberFormat($row->vote_average)."%" : "NR" ; ?></text>
                                            </svg>
                                        </div>
                                        <!--                                    percentage circle end-->
                                        <a href="" class="title text-decoration-none text-dark">
                                            <h6 class="card-title"><?php echo isset($row->original_name) ? $row->original_name : $row->original_title; ?></h6>
                                        </a>
                                        <p class="card-text text-black-50"><?php echo isset($row->first_air_date) ? showDate($row->first_air_date) : showDate($row->release_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="trendingByWeek" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row on-theater card-no-wrap overflow-scroll">
                        <?php foreach ($trendByWeekResults as $row) { ?>
                            <div class="mb-3" style="width: 15.5%">

                                <div class="card h-100 rounded-3 ">
                                    <?php if (empty($row->poster_path)){ ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                                        <div class="d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 239px;">
                                            <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                        </div>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                            <img src="https://image.tmdb.org/t/p/w220_and_h330_face<?php echo $row->poster_path; ?>" class="rounded-top card-img-top" style="height: 239px; alt="">
                                        </a>
                                    <?php } ?>

                                    <div class="card-body position-relative pt-4">
                                        <!--                                    percentage circle start-->
                                        <div class="single-chart position-absolute" style="top: -35px; left: 5px">
                                            <svg viewBox="0 0 36 36" class="circular-chart
                                        <?php
                                            $votePercentage = numberFormat($row->vote_average);
                                            if ($votePercentage <= 40 && $votePercentage > 1) {
                                                echo "red";
                                            } elseif ($votePercentage < 70 && $votePercentage >= 40) {
                                                echo "orange";
                                            } elseif ($votePercentage >= 70) {
                                                echo "green";
                                            } elseif ($votePercentage = 1) {
                                                echo "";
                                            }

                                            ?>
                                        ">
                                                <path class="circle-bg"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <path class="circle"
                                                      stroke-dasharray="30, 100"
                                                      d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                                />
                                                <text x="18" y="20.35" class="percentage"><?php echo numberFormat($row->vote_average) > 1 ? numberFormat($row->vote_average)."%" : "NR" ; ?></text>
                                            </svg>
                                        </div>
                                        <!--                                    percentage circle end-->
                                        <a href="" class="title text-decoration-none text-dark">
                                            <h6 class="card-title"><?php echo isset($row->original_name) ? $row->original_name : $row->original_title; ?></h6>
                                        </a>
                                        <p class="card-text text-black-50"><?php echo isset($row->first_air_date) ? showDate($row->first_air_date) : showDate($row->release_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<!--        trending end-->
    </div>
</div>



<script src="<?php echo $url; ?>/assets/js/app.js"></script>
<script src="<?php echo $url; ?>/node_modules/jquery/dist/jquery-1.11.0.min.js"></script>
<script src="<?php echo $url; ?>/node_modules/jquery/dist/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo $url; ?>/node_modules/slick/slick.min.js"></script>

<script src="<?php echo $url; ?>/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="<?php echo $url; ?>/assets/js/jquery.simplePagination.js"></script>
<script>
 // pagination start

 let items = $(".list-wrapper .list-item");
 let numItems = 10000;
 let perPage = 20;

 items.slice(perPage).hide();

 $('#pagination-container').pagination({
  items: numItems,
  itemsOnPage: perPage,
  prevText: "&laquo;",
  nextText: "&raquo;",
  onPageClick: function (pageNumber) {
   let showFrom = perPage * (pageNumber - 1);
   let showTo = showFrom + perPage;
   items.hide().slice(showFrom, showTo).show();
  }
 });

 // pagination end

 //slick start

 $(".on-theater").slick({
     dots: true,
     infinite: true,
     arrows: false,
     speed: 300,
     slidesToShow: 3,
     slidesToScroll: 1,
     responsive: [
         {
             breakpoint: 1400,
             settings: {
                 slidesToShow: 3,
                 slidesToScroll: 1,
                 infinite: true,
                 autoplay: true,
                 dots: true
             }
         },
         {
             breakpoint: 800,
             settings: {
                 slidesToShow: 2,
                 slidesToScroll: 2
             }
         },
         {
             breakpoint: 480,
             settings: {
                 slidesToShow: 1,
                 slidesToScroll: 1,
                 autoplay: true,
                 autoplaySpeed: 1000,
             }
         }
         // You can unslick at a given breakpoint now by adding:
         // settings: "unslick"
         // instead of a settings object
     ]
 });
 //slick end


</body>
</html>