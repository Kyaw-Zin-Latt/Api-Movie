<?php
require_once "../template/header.php";
$tvId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/tv/$tvId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=videos%2Caggregate_credits%2Creviews%2Crecommendations%2Ckeywords");
$dataLanguages = file_get_contents("https://api.themoviedb.org/3/configuration/languages?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400");
$dataImages = file_get_contents("https://api.themoviedb.org/3/tv/$tvId/images?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images&include_image_language=en,null");
$row = json_decode($data);
$rowLanguage = json_decode($dataLanguages);
$rowDetails = $row;
$rowGenres = $row->genres;

$currentSeason = end($rowDetails->seasons);

$data = file_get_contents("https://api.themoviedb.org/3/tv/$tvId/season/1?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataEpisodes = json_decode($data);
$dataEpisodesArr = $dataEpisodes->episodes;

$rowKeywords = $row->keywords->results;

$dataVideoResult = $row->videos->results;
$dataForTrailer= array_slice(array_reverse($dataVideoResult),0,1);


$dataVideosResult = $row->videos->results;
$dataSlicedVideosArr = array_slice(array_reverse($dataVideosResult),0,6);

$dataPeopleCasts = $row->aggregate_credits->cast;
$dataPeopleCrew = $row->aggregate_credits->crew;

$dataSlicedPeopleArr = array_slice($dataPeopleCasts,0,9);

$dataReviewSlicedResult = array_slice($row->reviews->results,0,1);
$dataReviewResult = $row->reviews->results;

$dataImagesArr = json_decode($dataImages);
$dataImagesBackdropsArr = $dataImagesArr->backdrops;
$dataSlicedImageBackdropsArr = array_slice($dataImagesBackdropsArr,0,6);
$dataImagesPostersArr = $dataImagesArr->posters;
$dataSlicedImagePostersArr = array_slice($dataImagesPostersArr,0,6);

$dataRecommendationVideosResultArr = $row->recommendations->results;

$dataMostPopularVideo = reset($dataSlicedVideosArr);
$dataMostPopularBackdrop = reset($dataImagesBackdropsArr);
$dataMostPopularPoster = reset($dataImagesPostersArr);



//echo "<pre>";
//
//print_r($dataVideosResult);
//
//echo "</pre>";
?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <div class="row bg-dark mb-2 mt-5">
        <div class="col-12 mt-4">
            <div class="">
                <video id="video-id">
                    <source src="https://cdn.fluidplayer.com/videos/valerian-480p.mkv" type="video/mp4"/>
                </video>
            </div>
        </div>
    </div>
</div>
<div class="h-100 cp-0 m-detail-bg-img" style="background-image: url('https://image.tmdb.org/t/p/w500<?php echo $row->backdrop_path; ?>');">
    <div class="cp-0 m-detail-bg">
        <div class="container">
            <div class="row pt-5 g-2 d-flex align-items-start align-items-md-center">
                <div class="col-4">
                    <img class="img-fluid" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2<?php echo $row->poster_path; ?>" alt="">
                    <div class="d-block d-md-none">
                        <?php foreach ($dataForTrailer as $rv){
                            if ($rv->site === "YouTube" || $rv->type === "Trailer"){
                                ?>
                                <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rv->key; ?>">
                                    <button class="btn btn-sm w-100 mt-1 btn-primary">Watch Trailer</button>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-8">
                    <div class="">
                        <h2 class="text-white">
                            <a href="" class="text-white fw-bold text-decoration-none"><?php echo $row->original_name; ?></a>
                            <span class="text-white-50">(<?php echo showDate($row->first_air_date,"Y"); ?>)</span>
                        </h2>
                        <p class="d-block d-md-none">
                            <i class="text-white-50"><?php echo $row->tagline; ?></i>
                        </p>
                        <div class="mb-4">
                             <span class="text-white">
                                 <i class="fas fa-calendar-alt text-primary"></i>
                                 <?php echo showDate($row->first_air_date,"m/d/Y"); ?>
                             </span>
                            <span class="text-white">
                                     &nbsp;
                                 <i class="fas fa-layer-group text-primary"></i>
                                <?php foreach ($rowGenres as $rg){ ?>
                                    <a href="<?php echo $url; ?>/discovers/genre_tv.php?id=<?php echo $rg->id; ?>" class="text-white text-decoration-none"><?php echo $rg->name; ?> ,</a>
                                <?php } ?>
                                 &nbsp;
                            </span>
                            <span class="text-white">
                                    <i class="fas fa-clock text-primary"></i> <?php echo minToHour(current($row->episode_run_time)); ?>
                                </span>
                            <span></span>
                        </div>
                        <div class="d-flex align-items-center d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="single-chart">
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
                                              stroke-dasharray="<?php echo $votePercentage; ?>, 100"
                                              d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                        />
                                        <text x="18" y="20.35" class="percentage"><?php echo numberFormat($row->vote_average) > 1 ? numberFormat($row->vote_average)."%" : "NR" ; ?></text>
                                    </svg>
                                </div>
                                <div class="">
                                    <p class="text-white mb-0">User <br> Score</p>
                                </div>
                            </div>
                        </div>
                        <div class="my-3 d-none d-md-block">
                            <h5>
                                <i class="text-white-50"><?php echo $row->tagline; ?></i>
                            </h5>
                        </div>
                        <div class="d-none d-md-block">
                            <?php foreach ($dataForTrailer as $rv){
                                if ($rv->site === "YouTube" || $rv->type === "Trailer"){
                                    ?>
                                    <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/<?php echo $rv->key; ?>">
                                        <button class="btn btn-lg w-md-5 mt-1 btn-primary">Watch Trailer</button>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="container">
    <div class="row d-block d-md-none">
        <h3 class="fw-bolder mt-3">Seasons</h3>
        <div class="">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Season1</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Season2</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Season3</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <?php foreach ($dataEpisodesArr as $row){ ?>
                        <div class="col-12">
                            <div class="card mb-1 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-12">
                                        <div class="rounded card-body py-2">
                                            <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                <h6 class="title card-title fw-bolder mb-0">Episode : <?php echo $row->episode_number ?> <?php echo $row->name; ?></h6>
                                            </a>
                                            <p class="card-text text-black-50"><?php echo showDate($row->air_date); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"></div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"></div>
            </div>
        </div>
        <hr>
    </div>
</div>
<div class="container d-block d-md-none">
    <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
        <li class="nav-item col-6" role="presentation">
            <button class="nav-link active w-100" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Info</button>
        </li>
        <li class="nav-item col-6" role="presentation">
            <button class="nav-link w-100" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Cast</button>
        </li>
        <li class="nav-item col-6" role="presentation">
            <button class="nav-link w-100" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Link</button>
        </li>
        <li class="nav-item col-6" role="presentation">
            <button class="nav-link w-100" id="pills-keywords-tab" data-bs-toggle="pill" data-bs-target="#pills-keywords" type="button" role="tab" aria-controls="pills-keywords" aria-selected="false">Keywords</button>
        </li>
    </ul>
</div>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade px-2 show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="row d-block d-md-none">
            <div class="col-12">
                <h3 class="">Overview</h3>
                <p class="">
                    အားလုံးစောင့်နေကြမယ့် ရှမ်းကြီးလာပါပြီ။ ဒီရုပ်ရှင်ဇာတ်လမ်းကတော့ End Game အပြီး လူတွေ ကမ္ဘာပေါ်ကိုပြန်ရောက်ရှိနေတဲ့ ကာလမှာ အခြေတည်ထားတာပဲဖြစ်ပါတယ်။ အဓိကဗီလိန်ကတော့ The Mandarine ပါ။
                    အိုင်ရွန်မန်း-၃ မှာတုန်းက မန်ဒရင်းအတုနဲ့တွေ့ခဲ့ကြတာ မှတ်မိကြဦးမှာပါ။ ဒီတစ်ခါတော့ မန်ဒရင်းအစစ်လာပါပြီ။

                    စူပါပါဝါတွေရယ် မသေမျိုးအဖြစ်ရယ်ကို ပေးနိုင်စွမ်းရှိတဲ့ ဒဏ္ဍာရီလာ ကွင်းဆယ်ကွင်းကို ပိုင်ဆိုင်ထားပြီး လျို့ဝှက်အဖွဲ့ကြီးတစ်ခုရဲ့ ခေါင်းဆောင်လည်းဖြစ်ပါတယ်။ ရှန်းချီကတော့ သူ့အဖေခိုင်းတာတွေကို မလုပ်ချင်တော့လို့ ငယ်ငယ်ကတည်းက အိမ်ကထွက်ပြေးပြီး ဇာတ်မြှပ်နေခဲ့တဲ့ သိုင်းသမားလေးပဲဖြစ်ပါတယ်။ ရှမ်းချီဇာတ်ကောင်ဟာ မာဗယ်ဟီးရိုးတွေထဲက သိုင်းအတော်ဆုံးဇာတ်ကောင်ဖြစ်ပြီး Iron Fist နဲ့ လက်ရည်တူလောက်ရှိပါတယ်။ ကပ္ပတိန်တို့စပိုက်ဒီတို့ကိုတောင် သိုင်းသင်ပေးဖူးပါသေးတယ်။ ဒီရုပ်ရှင်အဆုံးမှာတော့ ထုံးစံအတိုင်း post-credit scene နှစ်ခုပါတာမို့ ရှာကြည့်ဖို့ မမေ့ပါနဲ့ဦးနော်။(ဒီဇာတ်လမ်းရဲ့ အညွှန်းနဲ့ ဘာသာပြန်ရေးသားပေးသူကတော့ Mr.Anderson ပဲဖြစ်ပါတယ်။)
                </p>
            </div>
        </div>
    </div>
    <div class="tab-pane fade px-2" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="col-12 d-block d-md-none">
            <h3 class="fw-bolder">Cast</h3>
            <ol class="list-group">
                <?php foreach ($dataSlicedPeopleArr as $row) { ?>
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
                            <?php
                            $character = [];
                            foreach ($row->roles as $role) {
                            array_push($character, $role->character);
                            }
                            ?>
                            <small class=""><?php echo implode(",",$character); ?></small>
                        </div>
                    </li>
                <?php } ?>
            </ol>
        </div>
    </div>
    <div class="tab-pane fade px-2" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
    <div class="tab-pane fade px-2" id="pills-keywords" role="tabpanel" aria-labelledby="pills-keywords-tab">
        <div class="mb-3">
            <h3 class="fw-bolder">Keywords</h3>
            <?php foreach ($rowKeywords as $keyword) { ?>
                <a href="<?php echo $url; ?>/discovers/keyword.php?movie_id=<?php echo $movieId; ?>&keyword_id=<?php echo $keyword->id; ?>" class="text-decoration-none">
                    <p class="mb-1 p-2 badge bg-primary rounded"><?php echo $keyword->name; ?></p>
                </a>
            <?php } ?>
        </div>
    </div>

</div>
<div class="container">
    <div class="row">
        <!--            Recommendations start in mobile-->
        <div class="col-12 d-block d-md-none">
            <hr>
            <h4 class="fw-bolder">
                Recommendations
            </h4>

            <div class="">
                <div class="g-1 d-flex overflow-scroll text-nowrap">
                    <?php foreach ($dataRecommendationVideosResultArr as $row){ ?>
                        <div class="col-4">

                            <div class="px-2">
                                <div class="position-relative">
                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="">
                                        <figure class="imghvr-fade rounded">
                                            <img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2<?php echo $row->backdrop_path; ?>" class="rounded img-fluid" alt="">
                                            <figcaption class="">
                                                <small class="position-absolute text-white c-rounded bg-secondary bottom-0 p-1" style="right: 0">
                                                    <i class="fas fa-star text-white p-1"> <?php echo numberFormat($row->vote_average); ?> %</i>
                                                </small>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <div class="d-flex">
                <a href="" class="text-decoration-none me-2">Home</a>
                <a href="" class="text-decoration-none">Movies</a>

            </div>
        </div>

        <!--            Recommendations end in mobile-->
    </div>
</div>
<div class="container d-none d-md-block">
    <div class="row my-3">
        <div class="col-9">

            <!--                series cast start-->
            <div class="my-3">
                <h4 class="my-3 fw-bolder">
                    Series Cast
                </h4>
                <div class="row g-2 card-no-wrap mb-2">
                    <?php foreach ($dataSlicedPeopleArr as $rpc){ ?>
                        <div class="col-2">
                            <div class="card mb-2 h-100">
                                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $rpc->id; ?>">
                                    <img src="https://image.tmdb.org/t/p/w235_and_h235_face<?php echo $rpc->profile_path; ?>" class="rounded-3 card-img-top" alt="">
                                </a>
                                <div class="p-1">
                                    <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $rpc->id; ?>" class="text-decoration-none text-nowrap text-dark fw-bolder card-text">
                                        <small><?php echo $rpc->original_name; ?></small>
                                    </a>
                                    <?php
                                    $episodes = 0;
                                    $character = [];
                                    foreach ($rpc->roles as $role) {
                                        $episodes += $role->episode_count;
                                        array_push($character, $role->character);
                                    }
                                    ?>
                                    <small class=""><?php echo implode(",",$character); ?></small>
                                    <br><small class="text-black-50"><?php echo $episodes ; ?> Eposides</small>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="col-2 mb-2">
                        <div class="card h-100">
                            <div class="card-body d-flex">
                                <p class="d-flex align-items-center">
                                    <a href="<?php echo $url; ?>/tv_shows/series_cast_and_crew.php/?id=<?php echo $tvId; ?>" class="text-dark text-decoration-none fw-bolder">View More <i class="text-dark fas fa-arrow-right"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="text-decoration-none text-black " href="<?php echo $url; ?>/tv_shows/series_cast_and_crew.php/?id=<?php echo $tvId; ?>">
                    <p class="fw-bolder">Full Cast & Crew</p>
                </a>
                <hr>
            </div>
            <!--                series cast end-->

            <!--            current season start-->
            <div class="mb-3">
                <h4 class="my-3 fw-bolder">
                    Current Season
                </h4>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3 shadow">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-2">
                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w260_and_h390_bestv2<?php echo $currentSeason->poster_path; ?>" alt="">
                                </div>
                                <div class="col-md-10">
                                    <div class="rounded card-body py-2">
                                        <a href="<?php echo $url; ?>/tv_shows/season.php?id=<?php echo $tvId; ?>&season_number=<?php echo $currentSeason->season_number; ?>" class="text-black text-decoration-none">
                                            <h4 class="title card-title fw-bolder mb-0"><?php echo $currentSeason->name; ?></h4>
                                        </a>
                                        <div class="mb-4">
                                            <p class="card-text text-black fw-bolder">
                                                <?php echo showDate($currentSeason->air_date,"Y"); ?> | <?php echo $currentSeason->episode_count; ?> Episodes
                                            </p>
                                        </div>
                                        <p class="card-text"><?php echo $currentSeason->name ?> of <?php echo $rowDetails->name; ?>  premiered on <?php echo showDate($currentSeason->air_date); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="text-decoration-none text-black " href="<?php echo $url; ?>/tv_shows/seasons.php/?id=<?php echo $tvId; ?>">
                    <p class="fw-bolder">View All Seasons</p>
                </a>
                <hr>
            </div>
            <!--            current season end-->


            <!--                Recommendations start-->
            <h4 class="fw-bolder">
                Recommendations
            </h4>

            <div class="">
                <div class="g-1 d-flex overflow-scroll text-nowrap">
                    <?php foreach ($dataRecommendationVideosResultArr as $row){ ?>
                        <div class="col-4">

                            <div class="px-2">
                                <div class="position-relative">
                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="">
                                        <figure class="imghvr-fade rounded">
                                            <img src="https://image.tmdb.org/t/p/w250_and_h141_face<?php echo $row->backdrop_path; ?>" class="rounded img-fluid" alt="">
                                            <figcaption class="">
                                                <small class="position-absolute text-white c-rounded bg-secondary bottom-0 p-1" style="right: 0">
                                                    <i class="fas fa-star text-white p-1"> <?php echo numberFormat($row->vote_average); ?> %</i>
                                                </small>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><?php echo $row->original_name; ?></small>
                                    <small><i class="text-primary fas fa-calendar"></i> <?php echo showDate($row->first_air_date,"m/d/Y"); ?></small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!--                Recommendations end-->
        </div>
        <div class="col-3 my-3">
                <div class="mb-3">
                    <p class="fw-bolder mb-0">Keywords</p>
                    <?php foreach ($rowKeywords as $keyword) { ?>
                        <a href="<?php echo $url; ?>/discovers/keyword_tv.php?tv_id=<?php echo $tvId; ?>&keyword_id=<?php echo $keyword->id; ?>" class="text-decoration-none">
                            <p class="mb-1 p-2 badge bg-primary rounded"><?php echo $keyword->name; ?></p>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../template/footer.php"; ?>
<script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>
<script src="<?php echo $url; ?>/node_modules/venobox/venobox/venobox.min.js"></script>
<script src="<?php echo $url; ?>/node_modules/image-hover/"></script>

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

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

<script>
    var myFP = fluidPlayer(
        'video-id',	{
            "layoutControls": {
                "controlBar": {
                    "autoHideTimeout": 3,
                    "animated": true,
                    "autoHide": true
                },
                "htmlOnPauseBlock": {
                    "html": null,
                    "height": null,
                    "width": null
                },
                "autoPlay": false,
                "mute": false,
                "allowTheatre": true,
                "playPauseAnimation": true,
                "playbackRateEnabled": false,
                "allowDownload": false,
                "playButtonShowing": true,
                "fillToContainer": true,
                "posterImage": ""
            },
            "vastOptions": {
                "adList": [],
                "adCTAText": false,
                "adCTATextPosition": ""
            }
        })
</script>


