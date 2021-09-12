<?php
require_once "../template/header.php";
if (isset($_POST['sort_by'])) {
    $sort_key = $_POST['sort_by'];
    $dataBySort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=<?php echo $sort_key ?>&include_adult=false&include_video=false&page=1&with_watch_monetization_types=flatrate");
    $sortMovies = json_decode($dataBySort);
    $sortMoviesResult = $sortMovies->results;

}
$data = file_get_contents("https://api.themoviedb.org/3/tv/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");

$popularTVShows = json_decode($data);
$popularTVShowsResult = $popularTVShows->results;





//print_r($popularTVShowsResult);

?>


    <div class="container-fluid">
        <div class="row">
            <!--        navbar start        -->
            <?php require_once "../components/navbar.php"; ?>
            <!--        navbar end          -->
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bolder my-4">Popular Movies</h3>
            </div>
            <div class="col-3">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class=" accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="mb-0">Sort</h5>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <h5 class="text-black-50">Sort Results By</h5>
                                <form id="sort" action="" method="post">
                                    <select class="form-select" name="sort_by" aria-label="Default select example">
                                        <option value="popularity.desc" selected>Popularity Descending</option>
                                        <option value="popularity.asc">Popularity Ascending</option>
                                        <option value="vote_average.desc">Rating Descending</option>
                                        <option value="vote_average.asc">Rating Ascending</option>
                                        <option value="primary_release_date.desc">Release Date Descending</option>
                                        <option value="primary_release_date.asc">Release Date Ascending</option>
                                        <option value="title.asc">Title (A-Z)</option>
                                        <option value="title.desc">Title (Z-A)</option>
                                    </select>
                                </form>
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
                                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion my-3" id="accordionExample3">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Where To Watch
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample3">
                            <div class="accordion-body">
                                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>
                    </div>
                </div>
                <button form="sort" class="w-100 border-secondary btn btn-light rounded-pill">Search</button>
            </div>
            <div class="col-9">
                <div class="row">
                    <?php if (isset($_POST['sort_by'])){ ?>

                        <?php foreach ($sortMoviesResult as $row) { ?>
                            <div class="mb-4" style="width: 19.5%">

                                <div class="card h-100 rounded-3">
                                    <img src="https://image.tmdb.org/t/p/w500<?php echo $row->poster_path; ?>" class="rounded-3" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row->name; ?></h5>
                                        <p class="card-text text-black-50"><?php echo showDate($row->first_air_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    <?php } else { ?>

                        <?php foreach ($popularTVShowsResult as $row) { ?>
                            <div class="mb-4" style="width: 19.5%">

                                <div class="card h-100 rounded-3">
                                    <img src="https://image.tmdb.org/t/p/w500<?php echo $row->poster_path; ?>" class="rounded-3" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row->name; ?></h5>
                                        <p class="card-text text-black-50"><?php echo showDate($row->first_air_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php require_once "../template/footer.php"; ?>