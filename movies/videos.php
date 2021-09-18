<?php
require_once "../template/header.php";
$movieId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/movie/$movieId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataVideo = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/videos?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataPeople = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/credits?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$row = json_decode($data);
//$rowGenres = $row->genres;
//
$dataVideoArr = json_decode($dataVideo);
$dataVideoResultAsc = $dataVideoArr->results;
$dataVideoResult = array_reverse($dataVideoResultAsc);

$rowsTrailer = [];
foreach ($dataVideoResult as $rowTrailer) {
    if ($rowTrailer->type == "Trailer") {
        array_push($rowsTrailer,$rowTrailer);
    }
}

$rowsTeaser = [];
foreach ($dataVideoResult as $rowTeaser) {
    if ($rowTeaser->type == "Teaser") {
        array_push($rowsTeaser,$rowTeaser);
    }
}

$rowsClip = [];
foreach ($dataVideoResult as $rowClip) {
    if ($rowClip->type == "Clip") {
        array_push($rowsClip,$rowClip);
    }
}

$rowsBehindScene = [];
foreach ($dataVideoResult as $rowBehindScene) {
    if ($rowBehindScene->type == "BehindScene") {
        array_push($rowsBehindScene,$rowBehindScene);
    }
}

$rowsBlooper = [];
foreach ($dataVideoResult as $rowBlooper) {
    if ($rowBlooper->type == "Blooper") {
        array_push($rowsBlooper,$rowBlooper);
    }
}

$rowsFeaturette = [];
foreach ($dataVideoResult as $rowFeaturette) {
    if ($rowFeaturette->type == "Featurette") {
        array_push($rowsFeaturette,$rowFeaturette);
    }
}


$dataPeopleArr = json_decode($dataPeople);
$dataPeopleCasts = $dataPeopleArr->cast;
$dataPeopleCrew = array_reverse($dataPeopleArr->crew);

//$dataSlicedPeopleArr = array_slice($dataPeopleCasts,0,9);


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
    <?php require_once "../components/header_small.php";  ?>
    <div class="row my-3">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="card rounded-3">
                            <div class="card-header bg-dark text-light">
                                <h4 class="mb-0 py-3">Videos</h4>
                            </div>
                            <div class="">
                                <div class="list-group rounded-0" id="list-tab" role="tablist">
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action active" id="list-trailer-list" data-bs-toggle="list" href="#list-trailer" role="tab" aria-controls="list-trailer">
                                        Trailers
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($rowsTrailer); ?></span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-teaser-list" data-bs-toggle="list" href="#list-teaser" role="tab" aria-controls="list-teaser">
                                        Teasers
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($rowsTeaser); ?></span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-clip-list" data-bs-toggle="list" href="#list-clip" role="tab" aria-controls="list-clip">
                                        Clip
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($rowsClip); ?></span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-behind-list" data-bs-toggle="list" href="#list-behind" role="tab" aria-controls="list-behind">
                                        Behind the Scenes
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($rowsBehindScene); ?></span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-blooper-list" data-bs-toggle="list" href="#list-blooper" role="tab" aria-controls="list-blooper">
                                        Bloopers
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($rowsBlooper); ?></span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-featurette-list" data-bs-toggle="list" href="#list-featurette" role="tab" aria-controls="list-featurette">
                                        Featurettes
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($rowsFeaturette); ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-trailer" role="tabpanel" aria-labelledby="list-trailer-list">
                                <?php if (countTotal($rowsTrailer) > 0){ ?>

                                    <?php
                                    foreach ($dataVideoResult as $rowTrailerVideo){
                                        if ($rowTrailerVideo->type == "Trailer"){
                                            ?>

                                            <div class="col-12">
                                                <div class="card mb-3 rounded-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="" style="width: 350px;">
                                                                <div class="media-videos-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rowTrailerVideo->key; ?>/hqdefault.jpg')">
                                                                    <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rowTrailerVideo->key; ?>">
                                                                            <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                                        </a>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="rounded card-body py-2">
                                                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                    <p class="mb-0 fw-bold"><?php echo $rowTrailerVideo->name; ?></p>
                                                                </a>
                                                                <small class="text-black">
                                                                    <i class="fas fa-film text-primary"></i> <?php echo $rowTrailerVideo->type; ?>
                                                                </small>
                                                                <small class="text-black">
                                                                    <i class="fas fa-calendar-alt text-primary"></i> <?php echo showDate($rowTrailerVideo->published_at); ?>
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                <?php } else { ?>

                                    <p class="alert alert-warning text-dark">There are no English trailer added to <?php echo $row->original_title; ?> .</p>

                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="list-teaser" role="tabpanel" aria-labelledby="list-teaser-list">
                                <?php if (countTotal($rowsTeaser) > 0){ ?>

                                    <?php
                                    foreach ($dataVideoResult as $rowTeaserVideo){
                                        if ($rowTeaserVideo->type == "Teaser"){
                                            ?>

                                            <div class="col-12">
                                                <div class="card mb-3 rounded-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="" style="width: 350px;">
                                                                <div class="media-videos-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rowTeaserVideo->key; ?>/hqdefault.jpg')">
                                                                    <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rowTeaserVideo->key; ?>">
                                                                            <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                                        </a>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="rounded card-body py-2">
                                                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                    <p class="mb-0 fw-bold"><?php echo $rowTeaserVideo->name; ?></p>
                                                                </a>
                                                                <small class="text-black">
                                                                    <i class="fas fa-film text-primary"></i> <?php echo $rowTeaserVideo->type; ?>
                                                                </small>
                                                                <small class="text-black">
                                                                    <i class="fas fa-calendar-alt text-primary"></i> <?php echo showDate($rowTeaserVideo->published_at); ?>
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                <?php } else { ?>

                                    <p class="alert alert-warning text-dark">There are no English teasers added to <?php echo $row->original_title; ?> .</p>

                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="list-clip" role="tabpanel" aria-labelledby="list-clip-list">
                                <?php if (countTotal($rowsClip) > 0){ ?>

                                    <?php
                                    foreach ($dataVideoResult as $rowClipVideo){
                                        if ($rowClipVideo->type == "Clip"){
                                            ?>

                                            <div class="col-12">
                                                <div class="card mb-3 rounded-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="" style="width: 350px;">
                                                                <div class="media-videos-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rowClipVideo->key; ?>/hqdefault.jpg')">
                                                                    <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rowClipVideo->key; ?>">
                                                                            <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                                        </a>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="rounded card-body py-2">
                                                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                    <p class="mb-0 fw-bold"><?php echo $rowClipVideo->name; ?></p>
                                                                </a>
                                                                <small class="text-black">
                                                                    <i class="fas fa-film text-primary"></i> <?php echo $rowClipVideo->type; ?>
                                                                </small>
                                                                <small class="text-black">
                                                                    <i class="fas fa-calendar-alt text-primary"></i> <?php echo showDate($rowClipVideo->published_at); ?>
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                <?php } else { ?>

                                    <p class="alert alert-warning text-dark">There are no English clips added to <?php echo $row->original_title; ?> .</p>

                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="list-behind" role="tabpanel" aria-labelledby="list-behind-list">
                                <?php if (countTotal($rowsBehindScene) > 0){ ?>

                                    <?php
                                    foreach ($dataVideoResult as $rowBehindSceneVideo){
                                        if ($rowBehindSceneVideo->type == "BehindScene"){
                                            ?>

                                            <div class="col-12">
                                                <div class="card mb-3 rounded-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="" style="width: 350px;">
                                                                <div class="media-videos-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rowBehindSceneVideo->key; ?>/hqdefault.jpg')">
                                                                    <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rowBehindSceneVideo->key; ?>">
                                                                            <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                                        </a>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="rounded card-body py-2">
                                                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                    <p class="mb-0 fw-bold"><?php echo $rowBehindSceneVideo->name; ?></p>
                                                                </a>
                                                                <small class="text-black">
                                                                    <i class="fas fa-film text-primary"></i> <?php echo $rowBehindSceneVideo->type; ?>
                                                                </small>
                                                                <small class="text-black">
                                                                    <i class="fas fa-calendar-alt text-primary"></i> <?php echo showDate($rowBehindSceneVideo->published_at); ?>
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                <?php } else { ?>

                                    <p class="alert alert-warning text-dark">There are no English behind the scenes added to <?php echo $row->original_title; ?> .</p>

                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="list-blooper" role="tabpanel" aria-labelledby="list-blooper-list">
                                <?php if (countTotal($rowsBlooper) > 0){ ?>

                                    <?php
                                    foreach ($dataVideoResult as $rowBlooperVideo){
                                        if ($rowBlooperVideo->type == "Blooper"){
                                            ?>

                                            <div class="col-12">
                                                <div class="card mb-3 rounded-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="" style="width: 350px;">
                                                                <div class="media-videos-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rowBlooperVideo->key; ?>/hqdefault.jpg')">
                                                                    <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rowBlooperVideo->key; ?>">
                                                                            <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                                        </a>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="rounded card-body py-2">
                                                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                    <p class="mb-0 fw-bold"><?php echo $rowBlooperVideo->name; ?></p>
                                                                </a>
                                                                <small class="text-black">
                                                                    <i class="fas fa-film text-primary"></i> <?php echo $rowBlooperVideo->type; ?>
                                                                </small>
                                                                <small class="text-black">
                                                                    <i class="fas fa-calendar-alt text-primary"></i> <?php echo showDate($rowBlooperVideo->published_at); ?>
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                <?php } else { ?>

                                    <p class="alert alert-warning text-dark">There are no English bloopers added to <?php echo $row->original_title; ?> .</p>

                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="list-featurette" role="tabpanel" aria-labelledby="list-featurette-list">
                                <?php if (countTotal($rowsFeaturette) > 0){ ?>

                                    <?php
                                    foreach ($dataVideoResult as $rowFeaturetteVideo){
                                        if ($rowFeaturetteVideo->type == "Featurette"){
                                            ?>

                                            <div class="col-12">
                                                <div class="card mb-3 rounded-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <div class="" style="width: 350px;">
                                                                <div class="media-videos-background" style="background-image: url('https://i.ytimg.com/vi/<?php echo $rowFeaturetteVideo->key; ?>/hqdefault.jpg')">
                                                                    <h1 class="h-100 d-flex justify-content-center align-items-center">
                                                                        <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rowFeaturetteVideo->key; ?>">
                                                                            <i class="display-1 text-white c-hover fas fa-play-circle"></i>
                                                                        </a>
                                                                    </h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="rounded card-body py-2">
                                                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                    <p class="mb-0 fw-bold"><?php echo $rowFeaturetteVideo->name; ?></p>
                                                                </a>
                                                                <small class="text-black">
                                                                    <i class="fas fa-film text-primary"></i> <?php echo $rowFeaturetteVideo->type; ?>
                                                                </small>
                                                                <small class="text-black">
                                                                    <i class="fas fa-calendar-alt text-primary"></i> <?php echo showDate($rowFeaturetteVideo->published_at); ?>
                                                                </small>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                    ?>

                                <?php } else { ?>

                                    <p class="alert alert-warning text-dark">There are no English Featurettes added to <?php echo $row->original_title; ?> .</p>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

