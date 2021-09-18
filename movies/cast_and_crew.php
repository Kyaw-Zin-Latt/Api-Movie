<?php
require_once "../template/header.php";
$movieId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/movie/$movieId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
//$dataVideo = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/videos?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataPeople = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/credits?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$row = json_decode($data);
//$rowGenres = $row->genres;
//
//$dataVideoArr = json_decode($dataVideo);
//$dataVideoResult = $dataVideoArr->results;
//
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
    <div class="row">
        <div class="col-12 bg-dark">
            <div class="container">
                <div class="row py-2">
                    <div class="col-12 d-flex align-items-center">
                        <img class="img-fluid rounded-3" src="https://image.tmdb.org/t/p/w58_and_h87_bestv2<?php echo $row->poster_path; ?>" alt="">
                        <div class="ms-3">
                            <h2 class="fw-bolder text-white">
                                <?php echo $row->original_title; ?>
                                <span class="text-white-50">(<?php echo showDate($row->release_date,"Y"); ?>)</span>
                            </h2>
                            <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $movieId; ?>" class="text-decoration-none text-white-50">
                                <i class="fas fa-arrow-left"></i> <p class="d-inline-block">Back to main</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h3 class="">
                            Casts <span class="text-black-50"><?php echo countTotal($dataPeopleCasts); ?></span>
                        </h3>
                        <ol class="list-group">
                            <?php foreach ($dataPeopleCasts as $row) { ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <?php if (empty($row->profile_path)){ ?>
                                        <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                            <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                        </a>

                                    <?php } else { ?>
                                        <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                            <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                        </a>
                                    <?php } ?>

                                    <div class="ms-2">
                                        <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                            <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                        </a>
                                        <p class="text-black-50 mb-0"><?php echo $row->character; ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                    <div class="col-6">
                        <h3 class="">
                            Crews <span class="text-black-50"><?php echo countTotal($dataPeopleCrew); ?></span>
                        </h3>
                        <h5 class="text-dark mt-3">Art</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Art"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Camera</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Camera"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Costume & Make-Up</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Costume & Make-Up"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Crew</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Crew"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Directing</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Directing"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Editing</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Editing"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Production</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Production"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Sound</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Sound"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Visual Effects</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Visual Effects"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                        <h5 class="text-dark mt-3">Writing</h5>
                        <ol>
                            <?php foreach ($dataPeopleCrew as $row) { ?>
                                <?php if ($row->department === "Writing"){ ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (empty($row->profile_path)){ ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                            </a>

                                        <?php } else { ?>
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                            </a>
                                        <?php } ?>

                                        <div class="ms-2">
                                            <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?></p>
                                            </a>
                                            <p class="text-black-50 mb-0"><?php echo $row->job; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
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

