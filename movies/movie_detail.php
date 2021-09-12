<?php
require_once "../template/header.php";
$movieId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/movie/$movieId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataVideo = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/videos?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataVideos = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/videos?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataPeople = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/credits?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataReview = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/reviews?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
$dataImages = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/images?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images&include_image_language=en,null");
$row = json_decode($data);
$rowGenres = $row->genres;

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





?>


    <div class="container-fluid">
        <div class="row">
            <!--        navbar start        -->
            <?php require_once "../components/navbar.php"; ?>
            <!--        navbar end          -->
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex my-2 justify-content-center align-items-center">
                    <div class="dropdown">
                        <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Overview
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Main</a></li>
                            <li><a class="dropdown-item" href="#">Alernative Title</a></li>
                            <li><a class="dropdown-item" href="#">Cast & Crew</a></li>
                            <li><a class="dropdown-item" href="#">Release Dates</a></li>
                            <li><a class="dropdown-item" href="#">Translations</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Changes</a></li>
                            <li><a class="dropdown-item" href="#">Report</a></li>
                            <li><a class="dropdown-item" href="#">Edit</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Media
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Backdrops</a></li>
                            <li><a class="dropdown-item" href="#">Logos</a></li>
                            <li><a class="dropdown-item" href="#">Posters</a></li>
                            <li><a class="dropdown-item" href="#">Videos</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Fandom
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Discussions</a></li>
                            <li><a class="dropdown-item" href="#">Reviews</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Share
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Share Link</a></li>
                            <li><a class="dropdown-item" href="#">Facebook</a></li>
                            <li><a class="dropdown-item" href="#">Tweet</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="h-100 cp-0" style="border-bottom: 1px solid #1b161a; background-position: right -200px top; background-size: cover; background-repeat: no-repeat; background-image: url('https://image.tmdb.org/t/p/w500<?php echo $row->backdrop_path; ?>'); width: 100%;position: relative;z-index: 1;height: 550px !important;">
        <div class="cp-0" style="height: 550px  ;background-image: linear-gradient(to right, rgba(10.59%, 8.63%, 10.20%, 1.00) 150px, rgba(10.59%, 8.63%, 10.20%, 0.84) 100%);">
            <div class="container">
                <div class="row pt-5 g-2 d-flex align-items-center">
                    <div class="col-4">
                        <img class="img-fluid" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2<?php echo $row->poster_path; ?>" alt="">
                    </div>
                    <div class="col-8">
                        <div class="">
                            <h2 class="text-white">
                                <a href="" class="text-white fw-bold text-decoration-none"><?php echo $row->original_title; ?></a>
                                <span class="text-white-50">(<?php echo showDate($row->release_date,"Y"); ?>)</span>
                            </h2>
                            <div class="mb-4">
                                <span class="text-white"><?php echo showDate($row->release_date,"m/d/Y"); ?> &nbsp; &#9900; &nbsp;</span>
                                <span class="text-white">
                                    <?php foreach ($rowGenres as $rg){ ?>
                                        <a href="<?php echo $url; ?>/genre/action.php?id=<?php echo $rg->id; ?>" class="text-white text-decoration-none"><?php echo $rg->name; ?> ,</a>
                                    <?php } ?>
                                </span>
                                <span class="text-white">
                                </span>
                                <span></span>
                            </div>
                            <div class="">
                                <?php foreach ($dataVideoResult as $rv){
                                    if ($rv->site === "YouTube" && $rv->type === "Trailer"){
                                ?>
                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rv->key; ?>">
                                            <i class="fas fa-play"></i> Play Trailer
                                        </a>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="my-3">
                                <h5>
                                    <i class="text-white-50"><?php echo $row->tagline; ?></i>
                                </h5>
                            </div>
                            <div class="">
                                <h3 class="text-white">Overview</h3>
                                <p class="text-white">
                                    <?php echo $row->overview; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-9">

<!--                top billed cast start-->
                <h4 class="my-3 fw-bolder">
                    Top Billed Cast
                </h4>
                <div class="row g-2 card-no-wrap mb-2">
                    <?php foreach ($dataSlicedPeopleArr as $rpc){ ?>
                        <div class="col-2">
                            <div class="card mb-2 h-100">
                                <img src="https://image.tmdb.org/t/p/w235_and_h235_face<?php echo $rpc->profile_path; ?>" class="rounded-3 card-img-top" alt="">
                                <div class="card-body">
                                    <a href="" class="text-decoration-none text-dark fw-bolder card-text"><?php echo $rpc->original_name; ?></a>
                                    <p class="text-nowrap"><?php echo $rpc->character; ?></p>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="col-2 mb-2">
                        <div class="card h-100">
                            <div class="card-body d-flex">
                                <p class="d-flex align-items-center">
                                    <a href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>" class="text-dark text-decoration-none fw-bolder">View More <i class="text-dark fas fa-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="text-decoration-none text-black " href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>">
                    <p class="fw-bolder">Full Cast & Crew</p>
                </a>
                <hr>
<!--                top billed cast end-->

<!--                social start-->
                <div class="">
                    <nav class="d-flex align-items-center">
                        <h4 class="fw-bolder me-3">
                            Social
                        </h4>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Reviews <span class="text-black-50"></span></button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <?php if (countTotal($dataReviewSlicedResult) > 0){ ?>

                                <div class="card shadow rounded-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="<?php echo substr($dataReviewSlicedResult[0]->author_details->avatar_path,1); ?>" alt="">
                                            <div class="ms-3">
                                                <h4 class="mb-0">
                                                    <a href="" class="text-decoration-none text-black">A review by <?php echo $dataReviewSlicedResult[0]->author;  ?></a>
                                                </h4>
                                                <small class="text-black-50">
                                                    Written by <b><?php echo $dataReviewSlicedResult[0]->author;  ?></b> on <?php echo showDate($dataReviewSlicedResult[0]->created_at);  ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="ps-5 py-3">
                                            <p class="ps-5">
                                                <?php echo short($dataReviewSlicedResult[0]->content,600); ?>
                                                <a href="" class="text-black fw-bolder">read more</a>.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <p>No Review</p>
                            <?php } ?>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"></div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                    </div>
                </div>
                <a class="mt-3 text-decoration-none text-black " href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>">
                    <p class="mt-3 fw-bolder">Read All Reviews</p>
                </a>
                <hr>
<!--                social end-->

<!--                media start-->
                <div class="">
                    <nav class="d-flex align-items-center">
                        <h4 class="fw-bolder me-3">
                            Media
                        </h4>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-mostPopular-tab" data-bs-toggle="tab" data-bs-target="#nav-mostPopular" type="button" role="tab" aria-controls="nav-mostPopular" aria-selected="true">Most Popular</button>
                            <button class="nav-link" id="nav-videos-tab" data-bs-toggle="tab" data-bs-target="#nav-videos" type="button" role="tab" aria-controls="nav-videos" aria-selected="false">Videos <span class="text-black-50"><?php echo countTotal($dataVideosResult); ?></span></button>
                            <button class="nav-link" id="nav-backdrops-tab" data-bs-toggle="tab" data-bs-target="#nav-backdrops" type="button" role="tab" aria-controls="nav-backdrops" aria-selected="false">Backdrops <span class="text-black-50"><?php echo countTotal($dataImagesBackdropsArr); ?></span></button>
                            <button class="nav-link" id="nav-posters-tab" data-bs-toggle="tab" data-bs-target="#nav-posters" type="button" role="tab" aria-controls="nav-posters" aria-selected="false">Posters <span class="text-black-50"><?php echo countTotal($dataImagesPostersArr); ?></span></button>

                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-mostPopular" role="tabpanel" aria-labelledby="nav-mostPopular-tab">
                            Most POpular
                        </div>
                        <div class="tab-pane fade" id="nav-videos" role="tabpanel" aria-labelledby="nav-videos-tab">
                            <div class="d-flex overflow-scroll">
                                <?php foreach ($dataSlicedVideosArr as $rv) { ?>
                                    <div class="" style="width: 530px;">
                                        <div class="media-video-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rv->key; ?>/hqdefault.jpg')">
                                            <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rv->key; ?>">
                                                    <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                </a>
                                            </h1>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (countTotal($dataVideosResult) > 7) { ?>
                                    <div class="col-3 mb-2">
                                        <div class="card h-100">
                                            <div class="card-body d-flex">
                                                <p class="d-flex align-items-center">
                                                    <a href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>" class="text-dark text-decoration-none fw-bolder">View More <i class="text-dark fas fa-arrow-right"></i></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-backdrops" role="tabpanel" aria-labelledby="nav-backdrops-tab">
                           <div class="d-flex overflow-scroll">
                               <?php foreach ($dataSlicedImageBackdropsArr as $row){ ?>
                                   <div class="">
                                       <img src="https://image.tmdb.org/t/p/w533_and_h300_bestv2<?php echo $row->file_path; ?>" alt="">
                                   </div>
                               <?php } ?>
                               <?php if (countTotal($dataImagesBackdropsArr) > 7) { ?>
                                   <div class="col-3 mb-2">
                                       <div class="card h-100">
                                           <div class="card-body d-flex">
                                               <p class="d-flex align-items-center">
                                                   <a href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>" class="text-dark text-decoration-none fw-bolder">View More <i class="text-dark fas fa-arrow-right"></i></a>
                                               </p>
                                           </div>
                                       </div>
                                   </div>
                               <?php } ?>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="nav-posters" role="tabpanel" aria-labelledby="nav-posters-tab">
                            <div class="d-flex overflow-scroll">
                                <?php foreach ($dataSlicedImagePostersArr as $row){ ?>
                                    <div class="">
                                        <img src="https://image.tmdb.org/t/p/w220_and_h330_bestv2<?php echo $row->file_path; ?>" alt="">
                                    </div>
                                <?php } ?>
                                <?php if (countTotal($dataImagesPostersArr) > 7) { ?>
                                    <div class="col-3 mb-2">
                                        <div class="card h-100">
                                            <div class="card-body d-flex">
                                                <p class="d-flex align-items-center">
                                                    <a href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>" class="text-dark text-decoration-none fw-bolder">View More <i class="text-dark fas fa-arrow-right"></i></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
                <hr>
<!--                media end-->



<!--                Recommendations start-->



<!--                Recommendations end-->
            </div>
            <div class="col-3"></div>
        </div>
    </div>

<?php require_once "../template/footer.php"; ?>
<script src="<?php echo $url; ?>/node_modules/venobox/venobox/venobox.min.js"></script>
<script>
    $(document).ready(function(){
        $('.venobox').venobox({
            arrowsColor : '#dc3545',
            closeColor : '#dc3545',
            numerationColor : '#dc3545',
            infinigall : true,
            numeratio : true,
        });
    });
</script>

