<?php
require_once "../template/header.php";

$tvId = $_GET['id'];
$data = file_get_contents("https://api.themoviedb.org/3/tv/$tvId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=videos%2Ccredits%2Creviews%2Crecommendations");
$dataImages = file_get_contents("https://api.themoviedb.org/3/tv/$tvId/images?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images&include_image_language=en,null");

$row = json_decode($data);
$dataImagesArr = json_decode($dataImages);
$dataImagesBackdropsArr = $dataImagesArr->backdrops;
$dataImagesPostersArr = $dataImagesArr->posters;
$dataVideosResult = $row->videos->results;

//$dataPostersResultAsc = $dataPostersArr->posters;
//$dataPostersResult = array_reverse($dataPostersResultAsc);
$dataPostersResult = $dataImagesArr->posters;



?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <?php require_once "../components/header_dropdown_tv.php"; ?>
    <?php require_once "../components/header_small_tv.php"; ?>
</div>
<div class="container">
    <div class="row mt-3">
        <?php foreach ($row->seasons as $r) { ?>
            <div class="col-12">
                <div class="card mb-3">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-1">
                            <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w130_and_h195_bestv2<?php echo $r->poster_path; ?>" alt="">
                        </div>
                        <div class="col-md-11">
                            <div class="rounded card-body py-2">
                                <div class="d-flex align-items-baseline mb-1">
                                    <a href="<?php echo $url; ?>/tv_shows/season.php?id=<?php echo $tvId; ?>&season_number=<?php echo $r->season_number; ?>" class="text-black text-decoration-none">
                                        <h4 class="title card-title fw-bolder mb-0 me-2"><?php echo $r->name; ?></h4>
                                    </a>
                                    <small class="card-text mb-0 text-black fw-bolder">
                                        <?php echo showDate($r->air_date,"Y"); ?> | <?php echo $r->episode_count; ?> Episodes
                                    </small>
                                </div>
                                <p class="card-text">Season <?php echo $r->season_number ?> of <?php echo $row->name; ?>  premiered on <?php echo showDate($r->air_date); ?></p>
                                <p class="card-text">
                                    <?php echo isset($r->overview) ? $r->overview : ""; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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

