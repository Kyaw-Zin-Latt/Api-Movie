<div class="row">
    <div class="col-12 bg-dark">
        <div class="container">
            <div class="row py-2">
                <div class="col-12 d-flex align-items-center">
                    <?php if (empty($row->profile_path)){ ?>
                        <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                            <div class="d-flex justify-content-center img-fluid rounded-3 align-items-center bg-secondary" style="height: 87px; width: 58px">
                                <img class="" src="https://img.icons8.com/material-rounded/40/000000/person-male.png"/>
                            </div>
                        </a>

                    <?php } else { ?>
                        <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                            <img class="img-fluid rounded-3" src="https://image.tmdb.org/t/p/w58_and_h87_bestv2<?php echo $row->profile_path; ?>" alt="">
                        </a>
                    <?php } ?>
                    <div class="ms-3">
                        <h2 class="fw-bolder text-white">
                            <a class="text-decoration-none c-hover text-white" href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $personId; ?>">
                                <?php echo $row->name; ?>
                            </a>
                        </h2>
                        <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $personId; ?>" class="text-decoration-none text-white-50">
                            <i class="fas fa-arrow-left"></i> <p class="d-inline-block">Back to main</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>