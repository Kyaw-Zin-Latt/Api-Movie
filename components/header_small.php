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