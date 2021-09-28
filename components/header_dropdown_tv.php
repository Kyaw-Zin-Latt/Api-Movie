<div class="row bg-light position-sticky top-0" style="padding-top: 60px; z-index: 1002;">
    <div class="col-12">
        <div class="d-flex my-2 justify-content-center align-items-center">
            <div class="dropdown">
                <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Overview
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/tv_shows_detail.php?id=<?php echo $tvId; ?>">Main</a></li>
                    <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/series_cast_and_crew.php/?id=<?php echo $tvId; ?>">Cast & Crew</a></li>
                    <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/seasons.php?id=<?php echo $tvId; ?>">Seasons</a></li>

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
                        <a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/backdrops.php/?id=<?php echo $tvId; ?>">
                            Backdrops <?php echo countTotal($dataImagesBackdropsArr); ?>
                        </a>
                    </li>
                    <!--                            <li><a class="dropdown-item" href="#">Logos</a></li>-->
                    <li>
                        <a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/posters.php/?id=<?php echo $tvId; ?>">
                            Posters <?php echo countTotal($dataImagesPostersArr); ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/videos.php/?id=<?php echo $tvId; ?>">
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