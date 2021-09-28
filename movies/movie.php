<?php
require_once "../template/header.php";
print_r($_POST);
$dataGenres = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$genresArr = json_decode($dataGenres);
$genresArrResult = $genresArr->genres;

//nothing
if (empty($_GET['page']) && empty($_POST['sort_by']) && empty($_GET['sort_by']) && empty($_POST['start']) && empty($_POST['end']) && empty($_POST['genres']) && empty($_GET['genres']) && empty($_POST['year']) && empty($_GET['year'])) {

    $dataBySort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_watch_monetization_types=flatrate");
    $popularMovieArr = json_decode($dataBySort);
    $popularMovieArrResult = $popularMovieArr->results;
}

//page
if (isset($_GET['page']) && (empty($_POST['sort_by']) && empty($_GET['sort_by']) && empty($_POST['start']) && empty($_POST['end']) && empty($_GET['start']) && empty($_GET['end']) && empty($_POST['genres']) && empty($_GET['genres']) && empty($_POST['year']) && empty($_GET['year']))) {
    $pageNumber = $_GET['page'];
    $data = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=$pageNumber");
    $popularMovieArr = json_decode($data);
    $popularMovieArrResult = $popularMovieArr->results;
}

//if (empty($_GET['page']) && (empty($_POST['sort_by'])) && empty($_GET['sort_by']) && empty($_POST['start']) && empty($_POST['end']) && empty($_GET['start']) && empty($_GET['end']) && empty($_POST['genres']) && empty($_POST['year']) && empty($_GET ['year'])) {
//    $data = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
//    $popularMovieArr = json_decode($data);
//    $popularMovieArrResult = $popularMovieArr->results;
//}

//sort_by
if ((isset($_POST['sort_by']) || isset($_GET['sort_by'])) && (empty($_POST['start']) && empty($_POST['end']) && empty($_GET['start']) && empty($_GET['end']) && empty($_POST['genres']) && empty($_GET['genres']) && empty($_POST['year']) && empty($_GET['year']))) {
    if (isset($_POST['sort_by'])) {
        $sort_key = $_POST['sort_by'];
        $pageNumber = 1;
    } else {
        $sort_key = $_GET['sort_by'];
        $pageNumber = $_GET['page'];
    }
    $dataBySort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&with_watch_monetization_types=flatrate");
    $popularMovieArr = json_decode($dataBySort);
    $popularMovieArrResult = $popularMovieArr->results;
}
$sort_key = "popularity.desc";




//if ((empty($_POST['start']) && empty($_POST['end']) && empty($_POST['sort_by'])) && (empty($_GET['start']) && empty($_GET['end']) && empty($_GET['sort_by']))) {
//    $data = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
//    $popularMovieArr = json_decode($data);
//    $popularMovieArrResult = $popularMovieArr->results;
//    echo "date";
//} else if ((isset($_POST['start']) && isset($_POST['end'])) && empty($_POST['sort_by'])) {
//    if ((isset($_POST['start']) && isset($_POST['end']))) {
//        $start = $_POST['start'];
//        $end = $_POST['end'];
//    } else {
//        $start = $_GET['start'];
//        $end = $_GET['end'];
//        $pageNumber = $_GET['page'];
//    }
//    $dataByDate = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=$pageNumber&primary_release_date.gte=$start&primary_release_date.lte=$end&with_watch_monetization_types=flatrate");
//    $popularMovieArr = json_decode($dataByDate);
//    $popularMovieArrResult = $popularMovieArr->results;
//    print_r($_POST);
//
//}

//start and end and sort_by
if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && empty($_POST['genres']) && empty($_POST['year'])) || (isset($_GET['start']) && isset($_GET['end']) && isset($_GET['sort_by']) && empty($_GET['genres']) && empty($_GET['year']))) {
    if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']))) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $sort_key = $_POST['sort_by'];
        $pageNumber = 1;
    } else {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $pageNumber = $_GET['page'];
        $sort_key = $_GET['sort_by'];
    }
    $dataByDateAndSort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&primary_release_date.gte=$start&primary_release_date.lte=$end&with_watch_monetization_types=flatrate");

    $popularMovieArr = json_decode($dataByDateAndSort);
    $popularMovieArrResult = $popularMovieArr->results;
    print_r($_GET);
}

//year and sort_by
if ((isset($_POST['year']) && isset($_POST['sort_by']) && empty($_POST['genres']) && empty($_POST['start']) && empty($_POST['end'])) || (isset($_GET['year']) && isset($_GET['sort_by']) && empty($_GET['genres']) && empty($_POST['start']) && empty($_POST['end']))) {
    if ((isset($_POST['year']) && isset($_POST['sort_by']))) {
        $year = $_POST['year'];
        $sort_key = $_POST['sort_by'];
        $pageNumber = 1;
    } else {
        $year = $_GET['year'];
        $pageNumber = $_GET['page'];
        $sort_key = $_GET['sort_by'];
    }
    $dataByDateAndSort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&primary_release_year=$year&with_watch_monetization_types=flatrate");

    $popularMovieArr = json_decode($dataByDateAndSort);
    $popularMovieArrResult = $popularMovieArr->results;
    print_r($_GET);
}

//genres and sort_by
if ((isset($_POST['genres']) && isset($_POST['sort_by']) || isset($_GET['genres']) && isset($_GET['sort_by'])) && (empty($_POST['start']) && empty($_POST['end']) && empty($_POST['year']) && empty($_GET['start']) && empty($_GET['end']) && empty($_GET['year']))) {
    if (isset($_POST['genres'])) {
        $ans = [];
        foreach ($_POST['genres'] as $row) {
            array_push($ans, $row);
        }
        $genresIdBeforeUrlCode = join(",", $ans);
        $genresId = urlencode(join(",", $ans));
        $sort_key = $_POST['sort_by'];
        $dataByGenres = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=1&with_genres=$genresId&with_watch_monetization_types=flatrate");
    } else {
        $genresIdBeforeUrlCode = $_GET['genres'];
        $ans = explode(",", $genresIdBeforeUrlCode);
        $genresId = urlencode($genresIdBeforeUrlCode);
        $sort_key = $_GET['sort_by'];
        $pageNumber = $_GET['page'];
        $dataByGenres = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&with_genres=$genresId&with_watch_monetization_types=flatrate");
    }
    $popularMovieArr = json_decode($dataByGenres);

    $popularMovieArrResult = $popularMovieArr->results;
    //    echo "hdd";
    //    print_r($ans);
}



//sort_by and genres and year
if ((isset($_POST['sort_by']) && isset($_POST['genres']) && isset($_POST['year']) && empty($_POST['start']) && empty($_POST['end'])) || (empty($_GET['start']) && empty($_GET['end']) && isset($_GET['sort_by']) && isset($_GET['genres']) && isset($_GET['year']))) {
    if ((isset($_POST['year']) && isset($_POST['sort_by']) && isset($_POST['genres']))) {
        $sort_key = $_POST['sort_by'];
        $year = $_POST['year'];
        $ans = [];
        foreach ($_POST['genres'] as $row) {
            array_push($ans, $row);
        }
        $genresIdBeforeUrlCode = join(",", $ans);
        $genresId = urlencode(join(",", $ans));
        $pageNumber = 1;
    } else {
        $pageNumber = $_GET['page'];
        $year = $_GET['year'];
        $genresIdBeforeUrlCode = $_GET['genres'];
        //string to array
        $ans = explode(",", $genresIdBeforeUrlCode);
        //change string to url format
        $genresId = urlencode($genresIdBeforeUrlCode);
        $sort_key = $_GET['sort_by'];
    }
    $dataBySortAndGenreAndYear = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&primary_release_year=$year&with_genres=$genresId&with_watch_monetization_types=flatrate");

    $popularMovieArr = json_decode($dataBySortAndGenreAndYear);
    $popularMovieArrResult = $popularMovieArr->results;
    //        print_r($_POST);
    //    echo "mg";
}




//start and end and sort_by and genres and year
if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && isset($_POST['genres']) && isset($_POST['year'])) || (isset($_GET['start']) && isset($_GET['end']) && isset($_GET['sort_by']) && isset($_GET['genres']) && isset($_GET['year']))) {
    if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && isset($_POST['genres']))) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $sort_key = $_POST['sort_by'];
        $year = $_POST['year'];
        $ans = [];
        foreach ($_POST['genres'] as $row) {
            array_push($ans, $row);
        }
        $genresIdBeforeUrlCode = join(",", $ans);
        $genresId = urlencode(join(",", $ans));
        $pageNumber = 1;
    } else {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $pageNumber = $_GET['page'];
        $year = $_GET['year'];
        $genresIdBeforeUrlCode = $_GET['genres'];
        //string to array
        $ans = explode(",", $genresIdBeforeUrlCode);
        //change string to url format
        $genresId = urlencode($genresIdBeforeUrlCode);
        $sort_key = $_GET['sort_by'];
    }
    $dataByDateAndSortAndGenreAndYear = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&primary_release_year=$year&primary_release_date.gte=$start&primary_release_date.lte=$end&with_genres=$genresId&with_watch_monetization_types=flatrate");

    $popularMovieArr = json_decode($dataByDateAndSortAndGenreAndYear);
    $popularMovieArrResult = $popularMovieArr->results;
    //    print_r($_GET);
    //    print_r($_POST);
    //    echo "mg mg";
}




//start and end and sort_by and genres
if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && isset($_POST['genres']) && empty($_POST['year'])) || (isset($_GET['start']) && isset($_GET['end']) && isset($_GET['sort_by']) && isset($_GET['genres']) && empty($_GET['year']))) {
    if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && isset($_POST['genres']))) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $sort_key = $_POST['sort_by'];
        $ans = [];
        foreach ($_POST['genres'] as $row) {
            array_push($ans, $row);
        }
        $genresIdBeforeUrlCode = join(",", $ans);
        $genresId = urlencode(join(",", $ans));
        $pageNumber = 1;
    } else {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $pageNumber = $_GET['page'];
        $genresIdBeforeUrlCode = $_GET['genres'];
        //string to array
        $ans = explode(",", $genresIdBeforeUrlCode);
        //change string to url format
        $genresId = urlencode($genresIdBeforeUrlCode);
        $sort_key = $_GET['sort_by'];
    }
    $dataByDateAndSortAndGenre = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&primary_release_date.gte=$start&primary_release_date.lte=$end&with_genres=$genresId&with_watch_monetization_types=flatrate");

    $popularMovieArr = json_decode($dataByDateAndSortAndGenre);
    $popularMovieArrResult = $popularMovieArr->results;
    //    print_r($_GET);
    //    print_r($_POST);
    //    echo "mg mg";
}

//start and end and sort_by and year
if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && isset($_POST['year']) && empty($_POST['genres'])) || (isset($_GET['start']) && isset($_GET['end']) && isset($_GET['sort_by']) && isset($_GET['year']) && empty($_GET['genres']))) {
    if ((isset($_POST['start']) && isset($_POST['end']) && isset($_POST['sort_by']) && isset($_POST['year']))) {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $sort_key = $_POST['sort_by'];
        $year = $_POST['year'];
        $pageNumber = 1;
    } else {
        $start = $_GET['start'];
        $end = $_GET['end'];
        $pageNumber = $_GET['page'];
        $year = $_GET['year'];
        $sort_key = $_GET['sort_by'];
    }
    $dataByDateAndSortAndGenre = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&primary_release_year=$year&primary_release_date.gte=$start&primary_release_date.lte=$end&with_watch_monetization_types=flatrate");

    $popularMovieArr = json_decode($dataByDateAndSortAndGenre);
    $popularMovieArrResult = $popularMovieArr->results;
    //    print_r($_GET);
    //    print_r($_POST);
    //    echo "mg mg";
}

?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bolder my-4">Popular Movies</h3>
                <?php if (isset($_POST['genres']) || isset($_POST['sort_by']) || isset($_POST['start']) || isset($_POST['end']) || isset($_GET['genres']) || isset($_GET['sort_by']) || isset($_GET['start']) || isset($_GET['end']) || isset($_GET['page'])) { ?>
                    <a href="<?php echo $url; ?>/movies/movie.php" class="btn btn-outline-primary">
                        Clear Filter and Sort
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <form action="" id="filter" method="post">
                <div class="accordion mb-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class=" accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="mb-0">Sort</h5>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <h5 class="text-black-50">Sort Results By</h5>
                                <!--                            <form action="" id="sort" method="post">-->
                                <select class="form-select" name="sort_by" aria-label="Default select example">
                                    <option value="popularity.desc" <?php echo $sort_key === "popularity.desc" ? "selected" : " " ?>>Popularity Descending</option>
                                    <option value="popularity.asc" <?php echo $sort_key === "popularity.asc" ? "selected" : " " ?>>Popularity Ascending</option>
                                    <option value="vote_average.desc" <?php echo $sort_key === "vote_average.desc" ? "selected" : " " ?>>Rating Descending</option>
                                    <option value="vote_average.asc" <?php echo $sort_key === "vote_average.asc" ? "selected" : " " ?>>Rating Ascending</option>
                                    <option value="primary_release_date.desc" <?php echo $sort_key === "primary_release_date.desc" ? "selected" : " " ?>> Release Date Descending</option>
                                    <option value="primary_release_date.asc" <?php echo $sort_key === "primary_release_date.asc" ? "selected" : " " ?>>Release Date Ascending</option>
                                    <option value="title.asc" <?php echo $sort_key === "title.asc" ? "selected" : " " ?>>Title (A-Z)</option>
                                    <option value="title.desc" <?php echo $sort_key === "title.desc" ? "selected" : " " ?>>Title (Z-A)</option>
                                </select>
                                <!--                            </form>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion my-3" id="accordionExample1">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Filters
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample1">
                            <div class="accordion-body">
                                <h5 class="text-black-50 fw-bolder">Search By Date</h5>
                                <div class="mb-2">
                                    <label for="from" class="form-label">Start Date</label>
                                    <input type="date" name="start" value="<?php echo isset($start) ? $start : ''; ?>" id="from" class="form-control">
                                </div>
                                <div class="">
                                    <label for="from" class="form-label">End Date</label>
                                    <input type="date" name="end" value="<?php echo isset($end) ? $end : ''; ?>" id="from" class="form-control">
                                </div>
                                <hr>
                                <h5 class="text-black-50 fw-bolder">Searh By Year</h5>
                                <div class="mb-2">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="number" placeholder="2021" name="year" value="<?php echo isset($year) ? $year : ''; ?>" id="year" class="form-control">
                                </div>
                                <hr>
                                <h5 class="text-black-50 fw-bolder">Genres</h5>
                                <?php foreach ($genresArrResult as $row) { ?>
                                    <?php if (isset($ans)) { ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="genres[]" type="checkbox" id="inlineCheckbox<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" <?php foreach ($ans as $id) { ?> <?php echo $row->id == $id ? "checked" : "" ?> <?php } ?>>
                                            <label class="form-check-label" for="inlineCheckbox<?php echo $row->id; ?>"><?php echo $row->name; ?></label>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" name="genres[]" type="checkbox" id="inlineCheckbox<?php echo $row->id; ?>" value="<?php echo $row->id; ?>">
                                            <label class="form-check-label" for="inlineCheckbox<?php echo $row->id; ?>"><?php echo $row->name; ?></label>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <button form="filter" class="w-100 border-secondary btn btn-light rounded-pill">Filter</button>
        </div>
        <div class="col-12 col-md-9">
            <div class="row list-wrapper">
                <?php if (countTotal($popularMovieArrResult) > 0) { ?>
                    <?php foreach ($popularMovieArrResult as $row) { ?>
                        <div class="mb-4" style="width: 19.5%">

                            <div class="card h-100 rounded-3">
                                <?php if (empty($row->poster_path)) { ?>
                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                                    <div class=" d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 239px;">
                                        <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png" />
                            </div>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                <img src="https://image.tmdb.org/t/p/w500<?php echo $row->poster_path; ?>" class="rounded-top card-img-top" style="height: 239px; alt="">
                                    </a>
                                <?php } ?>

                                <div class=" card-body position-relative pt-4">
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
                                        <path class="circle-bg" d="M18 2.0845
                                                  a 15.9155 15.9155 0 0 1 0 31.831
                                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="circle" stroke-dasharray="30, 100" d="M18 2.0845
                                                  a 15.9155 15.9155 0 0 1 0 31.831
                                                  a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <text x="18" y="20.35" class="percentage"><?php echo numberFormat($row->vote_average) > 1 ? numberFormat($row->vote_average) . "%" : "NR"; ?></text>
                                    </svg>
                                </div>
                                <!--                                    percentage circle end-->
                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="title text-decoration-none text-dark">
                                    <h6 class="card-title"><?php echo $row->title; ?></h6>
                                </a>
                                <p class="card-text text-black-50"><?php echo showDate($row->release_date); ?></p>
                        </div>
            </div>
        </div>
    <?php } ?>
    <div id="pagination-container" class="align-items-start mt-3 fs"></div>
<?php } else { ?>
    <h3 class="alert alert-warning fw-bolder text-center">
        Sorry!!!. <br> No content available.😢😢😢
    </h3>
<?php } ?>
    </div>
</div>
</div>
</div>

<script src="<?php echo $url; ?>/node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?php echo $url; ?>/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>

<script>
    // jquery.pagination.file.custom start

    (function($) {

        var methods = {
            init: function(options) {
                var o = $.extend({
                    items: 0,
                    itemsOnPage: 0,
                    pages: 0,
                    displayedPages: <?php echo $popularMovieArr->total_pages; ?>,
                    edges: 2,
                    currentPage: 0,
                    hrefTextPrefix: '?page=',
                    hrefTextSuffix:

                        '<?php echo isset($_POST["sort_by"]) || isset($sort_key) ? "&sort_by=$sort_key" : "" ?><?php echo empty($start) ? "" : "&start=$start&end=$end" ?><?php echo empty($year) ? '' : "&year=$year" ?><?php echo empty($ans) ? "" : "&genres=$genresIdBeforeUrlCode" ?>',
                    prevText: 'Prev',
                    nextText: 'Next',
                    ellipseText: '&hellip;',
                    cssStyle: 'light-theme',
                    selectOnClick: true,
                    onPageClick: function(pageNumber, event) {
                        // Callback triggered when a page is clicked
                        // Page number is given as an optional parameter
                    },
                    onInit: function() {
                        // Callback triggered immediately after initialization
                    }
                }, options || {});

                var self = this;

                o.pages = o.pages ? o.pages : Math.ceil(o.items / o.itemsOnPage) ? Math.ceil(o.items / o.itemsOnPage) : 1;
                o.currentPage = o.currentPage - 1;
                o.halfDisplayed = o.displayedPages / 2;

                this.each(function() {
                    self.addClass(o.cssStyle + ' simple-pagination').data('pagination', o);
                    methods._draw.call(self);
                });

                o.onInit();

                return this;
            },

            selectPage: function(page) {
                methods._selectPage.call(this, page - 1);
                return this;
            },

            prevPage: function() {
                var o = this.data('pagination');
                if (o.currentPage > 0) {
                    methods._selectPage.call(this, o.currentPage - 1);
                }
                return this;
            },

            nextPage: function() {
                var o = this.data('pagination');
                if (o.currentPage < o.pages - 1) {
                    methods._selectPage.call(this, o.currentPage + 1);
                }
                return this;
            },

            getPagesCount: function() {
                return this.data('pagination').pages;
            },

            getCurrentPage: function() {
                return this.data('pagination').currentPage + 1;
            },

            destroy: function() {
                this.empty();
                return this;
            },

            redraw: function() {
                methods._draw.call(this);
                return this;
            },

            disable: function() {
                var o = this.data('pagination');
                o.disabled = true;
                this.data('pagination', o);
                methods._draw.call(this);
                return this;
            },

            enable: function() {
                var o = this.data('pagination');
                o.disabled = false;
                this.data('pagination', o);
                methods._draw.call(this);
                return this;
            },

            updateItems: function(newItems) {
                var o = this.data('pagination');
                o.items = newItems;
                o.pages = Math.ceil(o.items / o.itemsOnPage) ? Math.ceil(o.items / o.itemsOnPage) : 1;
                this.data('pagination', o);
                methods._draw.call(this);
            },

            _draw: function() {
                var o = this.data('pagination'),
                    interval = methods._getInterval(o),
                    i;

                methods.destroy.call(this);

                var $panel = this.prop("tagName") === "UL" ? this : $('<ul></ul>').appendTo(this);

                // Generate Prev link
                if (o.prevText) {
                    methods._appendItem.call(this, o.currentPage - 1, {
                        text: o.prevText,
                        classes: 'prev'
                    });
                }

                // Generate start edges
                if (interval.start > 0 && o.edges > 0) {
                    var end = Math.min(o.edges, interval.start);
                    for (i = 0; i < end; i++) {
                        methods._appendItem.call(this, i);
                    }
                    if (o.edges < interval.start && (interval.start - o.edges != 1)) {
                        $panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
                    } else if (interval.start - o.edges == 1) {
                        methods._appendItem.call(this, o.edges);
                    }
                }

                // Generate interval links
                for (i = interval.start; i < interval.end; i++) {
                    methods._appendItem.call(this, i);
                }

                // Generate end edges
                if (interval.end < o.pages && o.edges > 0) {
                    if (o.pages - o.edges > interval.end && (o.pages - o.edges - interval.end != 1)) {
                        $panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
                    } else if (o.pages - o.edges - interval.end == 1) {
                        methods._appendItem.call(this, interval.end++);
                    }
                    var begin = Math.max(o.pages - o.edges, interval.end);
                    for (i = begin; i < o.pages; i++) {
                        methods._appendItem.call(this, i);
                    }
                }

                // Generate Next link
                if (o.nextText) {
                    methods._appendItem.call(this, o.currentPage + 1, {
                        text: o.nextText,
                        classes: 'next'
                    });
                }
            },

            _getInterval: function(o) {
                return {
                    start: Math.ceil(o.currentPage > o.halfDisplayed ? Math.max(Math.min(o.currentPage - o.halfDisplayed, (o.pages - o.displayedPages)), 0) : 0),
                    end: Math.ceil(o.currentPage > o.halfDisplayed ? Math.min(o.currentPage + o.halfDisplayed, o.pages) : Math.min(o.displayedPages, o.pages))
                };
            },

            _appendItem: function(pageIndex, opts) {
                var self = this,
                    options, $link, o = self.data('pagination'),
                    $linkWrapper = $('<li></li>'),
                    $ul = self.find('ul');

                pageIndex = pageIndex < 0 ? 0 : (pageIndex < o.pages ? pageIndex : o.pages - 1);

                options = $.extend({
                    text: pageIndex + 1,
                    classes: ''
                }, opts || {});

                if (pageIndex == o.currentPage || o.disabled) {
                    if (o.disabled) {
                        $linkWrapper.addClass('disabled');
                    } else {
                        $linkWrapper.addClass('active');
                    }
                    $link = $('<span class="current">' + (options.text) + '</span>');
                } else {
                    $link = $('<a href="' + o.hrefTextPrefix + (pageIndex + 1) + o.hrefTextSuffix + '" class="page-link">' + (options.text) + '</a>');
                    $link.click(function(event) {
                        return methods._selectPage.call(self, pageIndex, event);
                    });
                }

                if (options.classes) {
                    $link.addClass(options.classes);
                }

                $linkWrapper.append($link);

                if ($ul.length) {
                    $ul.append($linkWrapper);
                } else {
                    self.append($linkWrapper);
                }
            },

            _selectPage: function(pageIndex, event) {
                var o = this.data('pagination');
                o.currentPage = pageIndex;
                if (o.selectOnClick) {
                    methods._draw.call(this);
                }
                return o.onPageClick(pageIndex + 1, event);
            }

        };

        $.fn.pagination = function(method) {

            // Method calling logic
            if (methods[method] && method.charAt(0) != '_') {
                return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof method === 'object' || !method) {
                return methods.init.apply(this, arguments);
            } else {
                $.error('Method ' + method + ' does not exist on jQuery.pagination');
            }

        };

    })(jQuery);

    // jquery.pagination.file.custom end

    let items = $(".list-wrapper .list-item");
    let numItems = <?php echo $popularMovieArr->total_results; ?>;
    let perPage = 20;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function(pageNumber) {
            let showFrom = perPage * (pageNumber - 1);
            let showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });

</script>
</body>

</html>
<script>


</script>