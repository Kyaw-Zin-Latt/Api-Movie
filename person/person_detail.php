<?php
require_once "../template/header.php";
$personId = $_GET['person_id'];

if (isset($_GET['media_type'])){
    $type = $_GET['media_type'];

}

$dataPersonDetail = file_get_contents("https://api.themoviedb.org/3/person/$personId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=external_ids%2Ccombined_credits%2Cmovie_credits%2Ctv_credits%2Cimages");
$dataPersonDetailArr = json_decode($dataPersonDetail);
$profileImagesArr = $dataPersonDetailArr->images->profiles;
$dataExternalIdArr = $dataPersonDetailArr->external_ids;

$dataCombinedCreditsCastArr = $dataPersonDetailArr->combined_credits->cast;

$mediaMovies = [];
$mediaTvs = [];
foreach ($dataCombinedCreditsCastArr as $mediaMovie) {
    if ($mediaMovie->media_type == "movie") {
        array_push($mediaMovies, $mediaMovie);
    }
}

foreach ($dataCombinedCreditsCastArr as $mediaTv) {
    if ($mediaTv->media_type == "tv") {
        array_push($mediaTvs, $mediaTv);
    }
}

if (isset($type)){
    if ($type=="movie") {
        $dataCombinedCreditsCastArr = $dataPersonDetailArr->movie_credits->cast;
        $dataCombinedCreditsCrewArr = $dataPersonDetailArr->movie_credits->crew;
    } else {
        $dataCombinedCreditsCastArr = $dataPersonDetailArr->tv_credits->cast;
        $dataCombinedCreditsCrewArr = $dataPersonDetailArr->tv_credits->crew;
    }

} else {
    $dataCombinedCreditsCastArr = $dataPersonDetailArr->combined_credits->cast;
    $dataCombinedCreditsCrewArr = $dataPersonDetailArr->combined_credits->crew;
}

$dataMovieCreditsCastArr = $dataPersonDetailArr->movie_credits->cast;
$dataMovieCreditsCrewArr = $dataPersonDetailArr->movie_credits->crew;
$dataMovieCreditsCastAndCrew = array_merge_recursive($dataMovieCreditsCastArr,$dataMovieCreditsCrewArr);

$dataTVShowCreditsCastArr = $dataPersonDetailArr->tv_credits->cast;
$dataTVShowCreditsCrewArr = $dataPersonDetailArr->tv_credits->crew;
$dataTVShowCreditsCastAndCrew = array_merge_recursive($dataTVShowCreditsCastArr,$dataTVShowCreditsCrewArr);
$derpartmentArr = [];


foreach ($dataCombinedCreditsCrewArr as $rowDepartment) {
    array_push($derpartmentArr,$rowDepartment->department);
}
$derpartmentArrUniqued = array_unique($derpartmentArr);



?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <?php require_once "../components/header_dropdown_person.php"; ?>
</div>

<div class="container">
    <div class="row">
        <div class="col-3">
            <?php if (empty($dataPersonDetailArr->profile_path)){ ?>
                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $dataPersonDetailArr->id; ?>">
                    <div class="d-flex justify-content-center img-fluid rounded-3 align-items-center bg-secondary" style="height: 450px; width: 300px">
                        <img class="" src="https://img.icons8.com/material-rounded/130/000000/person-male.png"/>
                    </div>
                </a>

            <?php } else { ?>
                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $dataPersonDetailArr->id; ?>">
                    <img class="rounded-3 mb-3 img-fluid" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2<?php echo $dataPersonDetailArr->profile_path; ?>" alt="">
                </a>
            <?php } ?>
            <div class="my-3">
                <a href="https://www.facebook.com/<?php echo $dataExternalIdArr->facebook_id; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Visit Facebook Page" class="text-decoration-none c-hover text-black">
                    <i class="fab fa-facebook-square fa-2x <?php echo empty($dataExternalIdArr->facebook_id) ? 'd-none' : '' ?>"></i>
                </a>
                <a href="https://instagram.com/<?php echo $dataExternalIdArr->instagram_id; ?>/" data-bs-toggle="tooltip" data-bs-placement="top" title="Visit Instagram Page" class="text-decoration-none c-hover text-black">
                    <i class="fab fa-instagram fa-2x <?php echo empty($dataExternalIdArr->instagram_id) ? 'd-none' : '' ?>"></i>
                </a>
                <a href="https://twitter.com/<?php echo $dataExternalIdArr->twitter_id; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Visit Twitter Page" class="text-decoration-none c-hover text-black">
                    <i class="fab fa-twitter fa-2x <?php echo empty($dataExternalIdArr->twitter_id) ? 'd-none' : '' ?>"></i>
                </a>
                <a href="<?php echo $dataPersonDetailArr->homepage; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Visit Home Page" class="text-decoration-none c-hover text-black">
                    <i class="fas fa-link fa-2x <?php echo empty($dataPersonDetailArr->homepage) ? 'd-none' : '' ?>"></i>
                </a>
            </div>
            <div class="">
                <h3 class="fw-bolder">Personal Info</h3>
                <div class="">
                    <p class="fw-bolder mb-0">Known For</p>
                    <p><?php echo $dataPersonDetailArr->known_for_department == null ? "-" : $dataPersonDetailArr->known_for_department ; ?></p>
                </div>
                <div class="">
                    <p class="fw-bolder mb-0">Known Credits</p>
                    <p><?php echo countTotal($dataMovieCreditsCastArr) + countTotal($dataTVShowCreditsCastArr); ?></p>
                </div>
                <div class="">
                    <p class="fw-bolder mb-0">Gender</p>
                    <p><?php echo ($dataPersonDetailArr->gender == 2 ? "Male" : ($dataPersonDetailArr->gender == 1 ? "Female" : ($dataPersonDetailArr->gender == null ? "-" : ""))); ?></p>
                </div>
                <div class="">
                    <p class="fw-bolder mb-0">Birthday</p>
                    <?php if ($dataPersonDetailArr->birthday !== null) { ?>
                    <p><?php echo $dataPersonDetailArr->birthday; ?> <span>(<?php echo showAge($dataPersonDetailArr->birthday); ?>years old)</span>  </p>
                    <?php } else { ?>
                    <p>-</p>
                    <?php } ?>
                </div>
                <div class="">
                    <p class="fw-bolder mb-0">Place of Birth</p>
                    <p><?php echo $dataPersonDetailArr->place_of_birth == null ? "-" : $dataPersonDetailArr->place_of_birth ; ?></p>
                </div>
                <div class="">
                    <p class="fw-bolder mb-0">Also Known As</p>
                    <p class="mb-0">
                        <?php if (countTotal($dataPersonDetailArr->also_known_as) > 0) { ?>

                            <?php foreach ($dataPersonDetailArr->also_known_as as $row){ ?>
                                <p class="mb-0"><?php echo $row; ?></p>
                            <?php } ?>

                        <?php } else { ?>
                            -
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-9">
            <h2 class="fw-bolder">
                <a href="" class="text-decoration-none c-hover text-black"><?php echo $dataPersonDetailArr->name; ?></a>
            </h2>
            <div class="my-5">

                <h5 class="fw-bolder">Biography</h5>
                <p class="article">
                    <?php echo empty($dataPersonDetailArr->biography) ? "We don't have a biography for $dataPersonDetailArr->name." : nl2br($dataPersonDetailArr->biography); ?>
                </p>
            </div>
<!--            Known for start-->
            <div class="">
                <?php if (!empty($dataMovieCreditsCastArr)) { ?>
                <h5 class="fw-bolder">Known For</h5>
                <div class="row g-1 card-no-wrap" style="overflow-x: scroll;">
                    <?php foreach ($dataMovieCreditsCastArr as $rowCast) { ?>
                        <div class="col-2">
                            <div class="card h-100">
                                <div class="">
                                    <a href="<?php ?>/movies/movie_detail.php?id=<?php echo $rowCast->id; ?>">
                                        <?php if ($rowCast->poster_path == null){ ?>
                                            <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary" style="height: 200px;">
                                                <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                            </div>
                                        <?php } else {  ?>
                                            <img class="rounded-3 mb-3 img-fluid" src="https://image.tmdb.org/t/p/w150_and_h225_bestv2<?php echo $rowCast->poster_path; ?>" alt="">
                                        <?php } ?>
                                    </a>
                                    <small class="text-center d-block">
                                        <a href="" class="text-decoration-none c-hover"><?php echo $rowCast->title; ?></a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
<!--            Known for end-->

<!--            known for department start-->
            <div class="my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bolder"><?php echo $dataPersonDetailArr->known_for_department; ?></h5>
                    <div class="dropdown">
                        <a class="text-decoration-none me-2" href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $personId; ?>"><?php echo isset($type) ? "clear" : "" ?></a>

                        <a class="text-decoration-none c-hover dropdown-toggle text-black me-2" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            All
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="<?php echo $url; ?>/person/person_detail.php?media_type=movie&person_id=<?php echo $personId ?>">Movies <span class="text-black-50"><?php echo countTotal($dataMovieCreditsCastAndCrew);?></span></a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?php echo $url; ?>/person/person_detail.php?media_type=tv&person_id=<?php echo $personId ?>">TV Shows <span class="text-black-50"><?php echo countTotal($dataTVShowCreditsCastAndCrew);?></span></a>
                            </li>
                        </ul>
                        <a class="text-decoration-none c-hover dropdown-toggle text-black" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                           Department
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php foreach ($derpartmentArrUniqued as $row) { ?>
                                <li>
                                    <a class="dropdown-item" href="#"><?php echo $row; ?> <span class="text-black-50"><?php echo countTotal($dataMovieCreditsCastAndCrew);?></span></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php if ($dataPersonDetailArr->known_for_department == "Acting") { ?>

                    <div class="">
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCastArr as $row){ ?>
                                <tr>
                                    <td class="text-center">
                                        <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                            -
                                        <?php } else {
                                            echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                        } ?>
                                    </td>
                                    <td>

                                        <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                           data-bs-content=
                                           '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                            <i class="fas fa-dot-circle"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo isset($row->original_title) ? $url.'/movies/movie_detail.php?id='.$row->id : $url.'/tv_shows/tv_shows_detail.php?id='.$row->id ; ?>" class="text-decoration-none c-hover text-dark">
                                            <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                        </a>
                                        <span class="text-black-50">
                                          <a href="<?php echo $url; ?>/tv_shows/tv_shows_detail.php?id=<?php echo $row->id; ?>" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        <span class=""><?php echo $row->character == null ? "" : "as " . $row->character  ?></span>
                                    </span>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>

<!--                    <div class="">-->
<!--                        <table class="table table-bordered">-->
<!--                            <tbody>-->
<!--                            --><?php //foreach ($dataCombinedCreditsCrewArr as $row){ ?>
<!---->
<!--                                --><?php //if ($dataPersonDetailArr->known_for_department == $row->department) { ?>
<!--                                    <tr>-->
<!--                                    <td>-->
<!--                                --><?php //if (empty($row->release_date) && empty($row->first_air_date)) { ?>
<!---->
<!--                                --><?php //} ?>
<!--                                --><?php //echo isset($row->release_date) ? showDate($row->release_date,'Y') : showDate($row->first_air_date,'Y'); ?>
<!--                                </td>-->
<!--                                <td>-->
<!---->
<!--                                    <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"-->
<!--                                       data-bs-content=-->
<!--                                       '-->
<!--                                        <div class="row g-0">-->
<!--                                            <div class="col-md-3">-->
<!--                                                --><?php //if ($row->poster_path == null){ ?>
<!--                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">-->
<!--                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>-->
<!--                                                </div>-->
<!--                                                --><?php //} else {  ?>
<!--                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2--><?php //echo $row->poster_path; ?><!--" alt="">-->
<!--                                                --><?php //} ?>
<!--                                            </div>-->
<!--                                            <div class="col-md-9">-->
<!--                                                <div class="rounded card-body py-2">-->
<!--                                                    <a href="--><?php //echo $url; ?><!--/movies/movie_detail.php?id=--><?php //echo $row->id; ?><!--" class="text-black text-decoration-none">-->
<!--                                                        <h5 class="title card-title fw-bolder mb-0">-->
<!--                                                            --><?php //echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
<!--                                                        </h5>-->
<!--                                                    </a>-->
<!--                                                    <p class="card-text">--><?php //echo short($row->overview,250); ?><!-- --><?php //echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?><!--</p>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        '>-->
<!---->
<!--                                        <i class="fas fa-dot-circle"></i>-->
<!--                                    </a>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <a href="" class="text-decoration-none c-hover text-dark">-->
<!--                                        --><?php //echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
<!--                                    </a>-->
<!--                                    <span class="text-black-50">-->
<!--                                          <a href="" class="text-decoration-none c-hover text-secondary">-->
<!--                                                --><?php //if (isset($row->episode_count)) { ?>
<!---->
<!--                                                    (--><?php //echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
<!--                                                    --><?php //echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?><!--)-->
<!---->
<!--                                                --><?php //} ?>
<!--                                          </a>-->
<!--                                        ... --><?php //echo $row->job; ?>
<!--                                    </span>-->
<!--                                </td>-->
<!--                                </tr>-->
<!--                                --><?php //} ?>
<!---->
<!--                            --><?php //} ?>
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->

                <?php } ?>


            </div>
<!--            known for department end-->

<!--            job start-->
            <div class="my-3">
                <?php if ($dataPersonDetailArr->known_for_department == "Acting") { ?>

                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Writing' ? 'd-block' : 'd-none' ?>">Writing</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Writing") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Sound' ? 'd-block' : 'd-none' ?>">Sound</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Sound") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Lighting' ? 'd-block' : 'd-none' ?>">Lighting</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Lighting") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Camera' ? 'd-block' : 'd-none' ?>">Camera</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Camera") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Editing' ? 'd-block' : 'd-none' ?>">Editing</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Editing") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Directing' ? 'd-block' : 'd-none' ?>">Directing</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Directing") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">

                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                             <h5 class="fw-bolder <?php echo $row=='Production' ? 'd-block' : 'd-none' ?>">Production</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Production") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : "" ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ''  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Costume & Make-Up' ? 'd-block' : 'd-none' ?>">Costume & Make-Up</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Costume & Make-Up") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Crew' ? 'd-block' : 'd-none' ?>">Crew</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Crew") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Actors' ? 'd-block' : 'd-none' ?>">Actors</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Actors") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Art' ? 'd-block' : 'd-none' ?>">Art</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Art") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="">
                        <?php foreach ($derpartmentArrUniqued as $row) { ?>
                            <h5 class="fw-bolder <?php echo $row=='Visual Effects' ? 'd-block' : 'd-none' ?>">Visual Effects</h5>
                        <?php } ?>
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($row->department == "Visual Effects") { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>

                <?php } else { ?>

                    <div class="">
                        <table class="table table-bordered">
                            <tbody>
                            <?php foreach ($dataCombinedCreditsCrewArr as $row){ ?>

                                <?php if ($dataPersonDetailArr->known_for_department == $row->department) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php if (empty($row->release_date) && empty($row->first_air_date)) { ?>
                                                -
                                            <?php } else {
                                                echo isset($row->release_date) ? showDate($row->release_date, 'Y') : showDate($row->first_air_date, 'Y');
                                            } ?>
                                        </td>
                                        <td>

                                            <a tabindex="2" class="c-hover text-decoration-none" role="button" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-html="true"
                                               data-bs-content=
                                               '
                                        <div class="row g-0">
                                            <div class="col-md-3">
                                                <?php if ($row->poster_path == null){ ?>
                                                <div class="d-flex mb-3 justify-content-center rounded-3 align-items-center bg-secondary h-100" style="height: 200px;">
                                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                                </div>
                                                <?php } else {  ?>
                                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rounded card-body py-2">
                                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                        <h5 class="title card-title fw-bolder mb-0">
                                                            <?php echo isset($row->original_title) ? textFilter($row->original_title) : textFilter($row->original_name) ; ?>
                                                        </h5>
                                                    </a>
                                                    <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (short(strlen($row->overview)) >= 150) ? "..." : " " ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        '>

                                                <i class="fas fa-dot-circle"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" class="text-decoration-none c-hover text-dark">
                                                <?php echo isset($row->original_title) ? $row->original_title : $row->original_name ; ?>
                                            </a>
                                            <span class="text-black-50">
                                          <a href="" class="text-decoration-none c-hover text-secondary">
                                                <?php if (isset($row->episode_count)) { ?>

                                                    (<?php echo isset($row->episode_count) ? $row->episode_count : '' ; ?>
                                                    <?php echo isset($row->episode_count) ? ($row->episode_count > 1 ? "episodes" : "episode") : ' '  ?>)

                                                <?php } ?>
                                          </a>
                                        ... <?php echo $row->job; ?>
                                    </span>
                                        </td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } ?>


            </div>
<!--            job end-->


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

    // tooltip start
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    // tooltip end

    // popover start
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
    // popover end

</script>


