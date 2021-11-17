<nav class="navbar navbar-expand-lg navbar-dark position-fixed top-0" style="z-index: 1003;background: #4a4a4a">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $url;  ?>/index.php">Navbar</a>
        <div class="form-check form-switch">
            <input class="form-check-input modeBtn" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url; ?>/movies/movie.php">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url; ?>/tv_shows/popular.php">TV Shows</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $url; ?>/person/person.php">People</a>
                </li>
            </ul>
            <form class="d-flex" method="post" action="<?php echo $url; ?>/search/search.php">
                <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>