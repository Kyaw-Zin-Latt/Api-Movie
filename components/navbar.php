<nav class="navbar navbar-expand-lg navbar-dark bg-primary position-fixed top-0" style="z-index: 999999">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $url;  ?>/index.php">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Movies
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/movies/movie.php">Popular</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/movies/now_playing.php">Now Playing</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/movies/upcoming.php">Upcoming</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/movies/top_rated.php">Top Rated</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        TV Shows
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/popular.php">Popular</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/airing_today.php">Airing Today</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/on_tv.php">On TV</a></li>
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/tv_shows/top_rated.php">Top Rated</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        People
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo $url; ?>/person/person.php">Popular People</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex" method="post" action="<?php echo $url; ?>/search/search.php">
                <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

