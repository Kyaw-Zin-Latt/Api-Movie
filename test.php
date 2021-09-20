
<a class="venobox" data-autoplay="true" data-vbtype="video" href="http://youtu.be/8YjFbMbfXaQ">Youtube</a>
https://api.themoviedb.org/3/movie/566525/images?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images&include_image_language=en,null

if ((empty($_POST['start']) && empty($_POST['end'])) || (empty($_GET['start']) && empty($_GET['end']))) {
$popularMovieArr = json_decode($data);
$popularMovieArrResult = $popularMovieArr->results;
} else {
if ((isset($_POST['start']) && isset($_POST['end']))) {
$start = $_POST['start'];
$end = $_POST['end'];
} else {
$start = $_GET['start'];
$end = $_GET['end'];
$pageNumber = $_GET['page'];
}
$dataByDate = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&primary_release_date.gte=$start&primary_release_date.lte=$end&with_watch_monetization_types=flatrate");
$dateMovies = json_decode($dataByDate);
$popularMovieArrResult = $dateMovies->results;
echo "date";
print_r($_POST);

}

if (isset($_POST['genres'])) {
if (isset($_POST['genres'])) {
$ans = [];
foreach ($_POST['genres'] as $row){
array_push($ans,$row);
}
$genresId = urlencode(join(",",$ans));
} else {$dataByGenres = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=$genresId&with_watch_monetization_types=flatrate");

$ans = [];
foreach ($_GET['genres'] as $row){
array_push($ans,$row);
}
$genresId = urlencode(join(",",$ans));
$pageNumber = $_GET['page'];
$dataByGenres = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=$pageNumber&with_genres=$genresId&with_watch_monetization_types=flatrate");
}
$dataMovies = json_decode($dataByGenres);
$popularMovieArrResult = $dataMovies->results;

echo "genres";
}




<?php if ((isset($_POST['sort_by']) || isset($_GET['sort_by'])) && (empty($_POST['start']) && empty($_POST['end']) && empty($_GET['start']) && empty($_GET['end'])) ){ ?>

    <?php foreach ($sortMoviesResult as $row) { ?>
        <div class="mb-4" style="width: 19.5%">

            <div class="card h-100 rounded-3">
                <?php if (empty($row->poster_path)){ ?>
                    <div class="">
                        <h1><i class="fas fa-image"></i></h1>
                    </div>

                <?php } else { ?>
                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo $row->poster_path; ?>" class="rounded-3 card-img-top" alt="">
                    </a>
                <?php } ?>
                <div class="card-body">
                    <a href="">
                        <h5 class="card-title"><?php echo $row->title; ?></h5>
                    </a>
                    <p class="card-text text-black-50"><?php echo showDate($row->release_date); ?></p>
                </div>
            </div>
        </div>
    <?php } ?>

<?php } else { ?>
    <?php foreach ($popularMovieArrResult as $row) { ?>
        <div class="mb-4" style="width: 19.5%">

            <div class="card h-100 rounded-3">
                <?php if (empty($row->poster_path)){ ?>
                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                    <img src="../assets/img/no-image.png" class="rounded-3 h-100 card-img-top" alt="">
                    </a>
                <?php } else { ?>
                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo $row->poster_path; ?>" class="rounded-3 card-img-top" alt="">
                    </a>
                <?php } ?>
                <div class="card-body">
                    <a href="" class="title text-decoration-none text-dark">
                        <h5 class="card-title"><?php echo $row->title; ?></h5>
                    </a>
                    <p class="card-text text-black-50"><?php echo showDate($row->release_date); ?></p>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>




$data = file_get_contents("https://api.themoviedb.org/3/tv/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");

$popularTVShows = json_decode($data);
$popularTVShowsResult = $popularTVShows->results;

//detail start but performance is not good
<?php
require_once "../template/header.php";
$tvId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/movie/$tvId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataKeyword = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/keywords?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400");
$dataVideo = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/videos?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataVideos = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/videos?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataPeople = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/credits?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataReview = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/reviews?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
$dataImages = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/images?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images&include_image_language=en,null");
$dataRecommendationVideos = file_get_contents("https://api.themoviedb.org/3/movie/$tvId/recommendations?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
$row = json_decode($data);
$rowDetails = $row;
$rowGenres = $row->genres;

$rowKeywordArr = json_decode($dataKeyword);
$rowKeywords = $rowKeywordArr->keywords;

$dataVideoArr = json_decode($dataVideo);
$dataVideoResult = $dataVideoArr->results;

$dataVideosArr = json_decode($dataVideos);
$dataVideosResult = $dataVideosArr->results;
$dataSlicedVideosArr = array_slice(array_reverse($dataVideosResult),0,6);

$dataPeopleArr = json_decode($dataPeople);
$dataPeopleCasts = $dataPeopleArr->cast;
$dataPeopleCrew = $dataPeopleArr->crew;

$dataSlicedPeopleArr = array_slice($dataPeopleCasts,0,9);


$dataReviewArr = json_decode($dataReview);
$dataReviewSlicedResult = array_slice($dataReviewArr->results,0,1);
$dataReviewResult = $dataReviewArr->results;

$dataImagesArr = json_decode($dataImages);
$dataImagesBackdropsArr = $dataImagesArr->backdrops;
$dataSlicedImageBackdropsArr = array_slice($dataImagesBackdropsArr,0,6);
$dataImagesPostersArr = $dataImagesArr->posters;
$dataSlicedImagePostersArr = array_slice($dataImagesPostersArr,0,6);

$dataRecommendationVideosArr = json_decode($dataRecommendationVideos);
$dataRecommendationVideosResultArr = $dataRecommendationVideosArr->results;

$dataMostPopularVideo = reset($dataSlicedVideosArr);
$dataMostPopularBackdrop = reset($dataImagesBackdropsArr);
$dataMostPopularPoster = reset($dataImagesPostersArr);

//detail end but performance is not good