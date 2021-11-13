<?php
require_once "../template/header.php";
$movieId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/movie/$movieId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=videos%2Ccredits%2Creviews%2Crecommendations%2Ckeywords");
$dataImages = file_get_contents("https://api.themoviedb.org/3/movie/$movieId/images?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images&include_image_language=en,null");

$row = json_decode($data);
$rowDetails = $row;
$rowGenres = $row->genres;

$rowKeywords = $row->keywords->keywords;

$dataVideoResult = $row->videos->results;

$dataVideosResult = $row->videos->results;
$dataSlicedVideosArr = array_slice(array_reverse($dataVideosResult),0,6);

$dataPeopleCasts = $row->credits->cast;
$dataPeopleCrew = $row->credits->crew;

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
    </div>
    <div class="container-fluid row bg-dark mb-4" style="padding-top: 60px; z-index: 1002;">
        <div class="row">
            <div class="col-12">
                <video id="video-id">
                    <source src="https://cdn.fluidplayer.com/videos/valerian-480p.mkv" type="video/mp4"/>
                </video>

            </div>
        </div>
    </div>
    <div class="h-100 cp-0" style="border-bottom: 1px solid #1b161a; background-position: right -200px top; background-size: cover; background-repeat: no-repeat; background-image: url('https://image.tmdb.org/t/p/w500<?php echo $row->backdrop_path; ?>'); width: 100%;position: relative;z-index: 1;height: 550px !important;">
        <div class="cp-0" style="height: 550px  ;    background-image: linear-gradient(to right, rgba(10.59%, 8.63%, 10.20%, 1.00) 150px, rgb(34 29 33 / 58%) 100%);">
            <div class="container">
                <div class="row pt-5 g-2 d-flex align-items-center">
                    <div class="col-4">
                        <img class="img-fluid" src="https://image.tmdb.org/t/p/w300_and_h450_bestv2<?php echo $row->poster_path; ?>" alt="">
                    </div>
                    <div class="col-8">
                        <div class="">
                            <h2 class="text-white">
                                <a href="" class="text-white fw-bold text-decoration-none"><?php echo $row->original_title; ?></a>
                                <span class="text-white">(<?php echo showDate($row->release_date,"Y"); ?>)</span>
                            </h2>
                            <div class="mb-4">
                                 <span class="text-white">
                                     <i class="fas fa-calendar-alt text-primary"></i>
                                     <?php echo showDate($row->release_date,"m/d/Y"); ?>
                                 </span>
                                 <span class="text-white">
                                     &nbsp;
                                     <i class="fas fa-layer-group text-primary"></i>
                                    <?php foreach ($rowGenres as $rg){ ?>
                                        <a href="<?php echo $url; ?>/discovers/action.php?id=<?php echo $rg->id; ?>" class="text-white text-decoration-none"><?php echo $rg->name; ?> ,</a>
                                    <?php } ?>
                                     &nbsp;
                                </span>
                                <span class="text-white">
                                    <i class="fas fa-clock text-primary"></i> <?php echo minToHour($row->runtime); ?>
                                </span>
                                <span></span>
                            </div>
                            <div class="d-flex align-items-center">
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
                                                  stroke-dasharray="30, 100"
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
<!--                                <div class="">-->
<!--                                    --><?php //foreach ($dataVideoResult as $rv){
//                                        if ($rv->site === "YouTube" && $rv->type === "Trailer"){
//                                            ?>
<!--                                            <a class="venobox text-white text-decoration-none" data-autoplay="true" data-vbtype="video" href="http://youtu.be/--><?php //echo $rv->key; ?><!--">-->
<!--                                                <i class="fas fa-play ms-5"></i> Play Trailer-->
<!--                                            </a>-->
<!--                                            --><?php
//                                        }
//                                    }
//                                    ?>
<!--                                </div>-->
                            </div>
                            <div class="my-3">
                                <h5>
                                    <i class="text-white-50"><?php echo $row->tagline; ?></i>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="">Overview</h3>
                <p class="">
                    အားလုံးစောင့်နေကြမယ့် ရှမ်းကြီးလာပါပြီ။ ဒီရုပ်ရှင်ဇာတ်လမ်းကတော့ End Game အပြီး လူတွေ ကမ္ဘာပေါ်ကိုပြန်ရောက်ရှိနေတဲ့ ကာလမှာ အခြေတည်ထားတာပဲဖြစ်ပါတယ်။ အဓိကဗီလိန်ကတော့ The Mandarine ပါ။
                    အိုင်ရွန်မန်း-၃ မှာတုန်းက မန်ဒရင်းအတုနဲ့တွေ့ခဲ့ကြတာ မှတ်မိကြဦးမှာပါ။ ဒီတစ်ခါတော့ မန်ဒရင်းအစစ်လာပါပြီ။

                    စူပါပါဝါတွေရယ် မသေမျိုးအဖြစ်ရယ်ကို ပေးနိုင်စွမ်းရှိတဲ့ ဒဏ္ဍာရီလာ ကွင်းဆယ်ကွင်းကို ပိုင်ဆိုင်ထားပြီး လျို့ဝှက်အဖွဲ့ကြီးတစ်ခုရဲ့ ခေါင်းဆောင်လည်းဖြစ်ပါတယ်။ ရှန်းချီကတော့ သူ့အဖေခိုင်းတာတွေကို မလုပ်ချင်တော့လို့ ငယ်ငယ်ကတည်းက အိမ်ကထွက်ပြေးပြီး ဇာတ်မြှပ်နေခဲ့တဲ့ သိုင်းသမားလေးပဲဖြစ်ပါတယ်။ ရှမ်းချီဇာတ်ကောင်ဟာ မာဗယ်ဟီးရိုးတွေထဲက သိုင်းအတော်ဆုံးဇာတ်ကောင်ဖြစ်ပြီး Iron Fist နဲ့ လက်ရည်တူလောက်ရှိပါတယ်။ ကပ္ပတိန်တို့စပိုက်ဒီတို့ကိုတောင် သိုင်းသင်ပေးဖူးပါသေးတယ်။ ဒီရုပ်ရှင်အဆုံးမှာတော့ ထုံးစံအတိုင်း post-credit scene နှစ်ခုပါတာမို့ ရှာကြည့်ဖို့ မမေ့ပါနဲ့ဦးနော်။(ဒီဇာတ်လမ်းရဲ့ အညွှန်းနဲ့ ဘာသာပြန်ရေးသားပေးသူကတော့ Mr.Anderson ပဲဖြစ်ပါတယ်။)
                </p>
            </div>
        </div>
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
                                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $rpc->id; ?>">
                                    <img src="https://image.tmdb.org/t/p/w235_and_h235_face<?php echo $rpc->profile_path; ?>" class="rounded-3 card-img-top" alt="">
                                </a>
                                <div class="card-body">
                                    <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $rpc->id; ?>" class="text-decoration-none text-dark fw-bolder card-text"><?php echo $rpc->original_name; ?></a>
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
<!--                <div class="">-->
<!--                    <nav class="d-flex align-items-center">-->
<!--                        <h4 class="fw-bolder me-3">-->
<!--                            Social-->
<!--                        </h4>-->
<!--                        <div class="nav nav-tabs" id="nav-tab" role="tablist">-->
<!--                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Reviews <span class="text-black-50"></span></button>-->
<!--                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>-->
<!--                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>-->
<!--                        </div>-->
<!--                    </nav>-->
<!--                    <div class="tab-content" id="nav-tabContent">-->
<!--                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">-->
<!--                            --><?php //if (countTotal($dataReviewSlicedResult) > 0){ ?>
<!---->
<!--                                <div class="card shadow rounded-3">-->
<!--                                    <div class="card-body">-->
<!--                                        <div class="d-flex align-items-center">-->
<!--                                            <img class="rounded-circle" src="--><?php //echo substr($dataReviewSlicedResult[0]->author_details->avatar_path,1); ?><!--" alt="">-->
<!--                                            <div class="ms-3">-->
<!--                                                <h4 class="mb-0">-->
<!--                                                    <a href="" class="text-decoration-none text-black">A review by --><?php //echo $dataReviewSlicedResult[0]->author;  ?><!--</a>-->
<!--                                                </h4>-->
<!--                                                <small class="text-black-50">-->
<!--                                                    Written by <b>--><?php //echo $dataReviewSlicedResult[0]->author;  ?><!--</b> on --><?php //echo showDate($dataReviewSlicedResult[0]->created_at);  ?>
<!--                                                </small>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="ps-5 py-3">-->
<!--                                            <p class="ps-5">-->
<!--                                                --><?php //echo short($dataReviewSlicedResult[0]->content,600); ?>
<!--                                                <a href="" class="text-black fw-bolder">read more</a>.-->
<!--                                            </p>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                            --><?php //} else { ?>
<!--                                <p>No Review</p>-->
<!--                            --><?php //} ?>
<!--                        </div>-->
<!--                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"></div>-->
<!--                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <a class="mt-3 text-decoration-none text-black c-hover" href="--><?php //echo $url; ?><!--/movies/cast_and_crew.php/?id=--><?php //echo $movieId; ?><!--">-->
<!--                    <p class="mt-3 fw-bolder">Read All Reviews</p>-->
<!--                </a>-->
<!--                <hr>-->
<!--                social end-->

<!--                media start-->

<!--                media end-->

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
                                        <p><?php echo $row->title; ?></p>
                                        <p><i class="text-primary fas fa-calendar"></i> <?php echo showDate($row->release_date,"m/d/Y"); ?></p>
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
                            <a href="<?php echo $url; ?>/discovers/keyword.php?movie_id=<?php echo $movieId; ?>&keyword_id=<?php echo $keyword->id; ?>" class="text-decoration-none">
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
                "autoPlay": true,
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

