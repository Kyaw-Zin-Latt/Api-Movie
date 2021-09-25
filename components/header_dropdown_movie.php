<div class="row">
    <div class="col-12">
        <div class="d-flex my-2 justify-content-center align-items-center">
            <div class="dropdown">
                <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Overview
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $movieId; ?>">Main</a></li>
                    <li><a class="dropdown-item" href="<?php echo $url; ?>/movies/cast_and_crew.php/?id=<?php echo $movieId; ?>">Cast & Crew</a></li>

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
                        <a class="dropdown-item" href="<?php echo $url; ?>/movies/backdrops.php/?id=<?php echo $movieId; ?>">
                            Backdrops <?php echo countTotal($dataImagesBackdropsArr); ?>
                        </a>
                    </li>
                    <!--                            <li><a class="dropdown-item" href="#">Logos</a></li>-->
                    <li>
                        <a class="dropdown-item" href="<?php echo $url; ?>/movies/posters.php/?id=<?php echo $movieId; ?>">
                            Posters <?php echo countTotal($dataImagesPostersArr); ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo $url; ?>/movies/videos.php/?id=<?php echo $movieId; ?>">
                            Videos <?php echo countTotal($dataVideosResult); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Fandom
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
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