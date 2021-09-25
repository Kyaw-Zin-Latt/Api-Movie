<?php
require_once "../template/header.php";
$personId = $_GET['person_id'];
$dataPersonDetail = file_get_contents("https://api.themoviedb.org/3/person/$personId?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&append_to_response=images");
$row = json_decode($dataPersonDetail);

$profileImagesArr = $row->images->profiles;


?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <?php require_once "../components/header_dropdown_person.php"; ?>

    <?php require_once "../components/header_small_person.php"; ?>
    <div class="row my-3">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="card rounded-3">
                            <div class="card-header bg-dark text-light">
                                <h4 class="mb-0 py-3">Images</h4>
                            </div>
                            <div class="">
                                <div class="list-group rounded-0" id="list-tab" role="tablist">
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action active" id="list-trailer-list" data-bs-toggle="list" href="#list-trailer" role="tab" aria-controls="list-trailer">
                                        Profiles
                                        <span class="badge rounded-pill bg-secondary"><?php echo countTotal($profileImagesArr); ?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-trailer" role="tabpanel" aria-labelledby="list-trailer-list">
                                <div class="row g-2">
                                    <?php if (countTotal($profileImagesArr) > 0){ ?>

                                        <?php foreach ($profileImagesArr as $rowEnglishPosters){ ?>

                                                <div class="col-4">
                                                    <div class="card rounded-3">
                                                        <a class="venobox" data-gall="gallery01" href="https://image.tmdb.org/t/p/w500<?php echo $rowEnglishPosters->file_path; ?>">
                                                            <img src="https://image.tmdb.org/t/p/original<?php echo $rowEnglishPosters->file_path; ?>" class="card-img-top" alt="...">
                                                        </a>
                                                        <div class="card-body">
                                                            <p class="mb-0"> <i class="fas fa-info-circle text-primary"></i> Info</p>
                                                            <hr>
                                                            <div class="">
                                                                <small>Size</small>
                                                                <p class="card-text">
                                                                    <?php echo $rowEnglishPosters->width; ?> x <?php echo $rowEnglishPosters->height; ?> <i class="far fa-check-circle text-primary"></i>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <p class="alert alert-warning text-dark">There no profiles added to this entry.</p>

                                    <?php } ?>
                                </div>
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

