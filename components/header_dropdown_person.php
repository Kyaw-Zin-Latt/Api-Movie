<div class="row">
    <div class="col-12">
        <div class="d-flex my-2 justify-content-center align-items-center">
            <div class="dropdown">
                <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Overview
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $personId; ?>">Main</a></li>
                    <!--                            <li><a class="dropdown-item" href="#">Release Dates</a></li>-->
                    <!--                            <li><a class="dropdown-item" href="#">Translations</a></li>-->
                    <!--                            <li><hr class="dropdown-divider"></li>-->
                    <!--                            <li><a class="dropdown-item" href="#">Changes</a></li>-->
                    <!--                            <li><a class="dropdown-item" href="#">Report</a></li>-->
                    <!--                            <li><a class="dropdown-item" href="#">Edit</a></li>-->
                </ul>
            </div>
            <div class="dropdown">
                <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Media
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li>
                        <a class="dropdown-item" href="<?php echo $url; ?>/person/profile.php?person_id=<?php echo $personId; ?>">
                            Profile <?php echo countTotal($profileImagesArr); ?>
                        </a>
                    </li>
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