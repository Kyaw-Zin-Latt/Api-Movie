<?php
require_once "../template/header.php";
$tvId = $_GET['id'];
$seasonNumber= $_GET['season_number'];
$data = file_get_contents("https://api.themoviedb.org/3/tv/$tvId/season/$seasonNumber?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataEpisodes = json_decode($data);
$dataEpisodesArr = $dataEpisodes->episodes;

if (isset($_GET['sort_by'])){
    $sortBy = $_GET['sort_by'];
    if ($sortBy == 'episode_number.asc') {
        $dataEpisodesArr = $dataEpisodes->episodes;
    } else {
        $dataEpisodesArr = array_reverse($dataEpisodesArr);
    }
}




?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex my-2 justify-content-center align-items-center">
                <div class="dropdown">
                    <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Overview
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Main</a></li>
                        <li><a class="dropdown-item" href="#">Alernative Title</a></li>
                        <li><a class="dropdown-item" href="#">Cast & Crew</a></li>
                        <li><a class="dropdown-item" href="#">Release Dates</a></li>
                        <li><a class="dropdown-item" href="#">Translations</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Changes</a></li>
                        <li><a class="dropdown-item" href="#">Report</a></li>
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Media
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Backdrops</a></li>
                        <li><a class="dropdown-item" href="#">Logos</a></li>
                        <li><a class="dropdown-item" href="#">Posters</a></li>
                        <li><a class="dropdown-item" href="#">Videos</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Fandom
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Discussions</a></li>
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
    <div class="row">
        <div class="col-12 bg-dark">
            <div class="container">
                <div class="row py-2">
                    <div class="col-12 d-flex align-items-center">
                        <img class="img-fluid rounded-3" src="https://image.tmdb.org/t/p/w58_and_h87_bestv2<?php echo $dataEpisodes->poster_path; ?>" alt="">
                        <div class="ms-3">
                            <h2 class="fw-bolder text-white">
                                <?php echo $dataEpisodes->name; ?>
                                <span class="text-white-50">(<?php echo showDate($dataEpisodes->air_date,"Y"); ?>)</span>
                            </h2>
                            <a href="<?php echo $url; ?>/tv_shows/seasons.php?id=<?php echo $tvId; ?>" class="text-decoration-none text-white-50">
                                <i class="fas fa-arrow-left"></i> <p class="d-inline-block">Back to Season List</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row list-wrapper">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                <h5 class="fw-bolder">
                    Episodes <span class="text-black-50"><?php echo countTotal($dataEpisodesArr); ?></span>
                </h5>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
                        <li>
                            <div class="btn-group dropend w-100">
                                <button type="button" class="w-100 btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Episode Number
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item <?php echo $sortBy=='episode_number.asc' ? 'active' : '' ?>" href="<?php echo $url; ?>/tv_shows/season.php?id=<?php echo $tvId ?>&season_number=<?php echo $seasonNumber ?>&sort_by=episode_number.asc">Ascending</a></li>
                                    <li><a class="dropdown-item <?php echo $sortBy=='episode_number.desc' ? 'active' : '' ?>" href="<?php echo $url; ?>/tv_shows/season.php?id=<?php echo $tvId ?>&season_number=<?php echo $seasonNumber ?>&sort_by=episode_number.desc">Descending</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="btn-group dropend w-100">
                                <button type="button" class="w-100 btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Air Date
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item <?php echo $sortBy=='episode_number.asc' ? 'active' : '' ?>" href="<?php echo $url; ?>/tv_shows/season.php?id=<?php echo $tvId ?>&season_number=<?php echo $seasonNumber ?>&sort_by=episode_number.asc">Ascending</a></li>
                                    <li><a class="dropdown-item <?php echo $sortBy=='episode_number.desc' ? 'active' : '' ?>" href="<?php echo $url; ?>/tv_shows/season.php?id=<?php echo $tvId ?>&season_number=<?php echo $seasonNumber ?>&sort_by=episode_number.desc">Descending</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php foreach ($dataEpisodesArr as $row){ ?>
            <div class="col-12">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <?php if (empty($row->still_path)){ ?>
                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" ">
                                <div class="d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 127px;">
                                    <img class="" src="https://img.icons8.com/material-outlined/60/000000/image.png"/>
                                </div>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                    <img class="rounded img-fluid" src="https://image.tmdb.org/t/p/w227_and_h127_bestv2<?php echo $row->still_path; ?>" alt="">
                                </a>
                            <?php } ?>
                        </div>
                        <div class="col-md-10">
                            <div class="rounded card-body py-2">
                                <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                    <h5 class="title card-title fw-bolder mb-0"><?php echo $row->episode_number ?> <?php echo $row->name; ?></h5>
                                </a>
                                <p class="card-text text-black-50"><?php echo showDate($row->air_date); ?></p>
                                <p class="card-text"><?php echo short($row->overview,250); ?> <?php echo (strlen($row->overview) >= 250) ? "..." : " " ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div id="pagination-container" class="align-items-start mt-3 fs"></div>
    </div>
</div>


<script src="<?php echo $url; ?>/node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?php echo $url; ?>/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>

<script>

    // jquery.pagination.file.custom start

    (function($){

        var methods = {
            init: function(options) {
                var o = $.extend({
                    items: 0,
                    itemsOnPage: 0,
                    pages: 0,
                    displayedPages: 5,
                    edges: 2,
                    currentPage: 0,
                    hrefTextPrefix: '?page=',
                    hrefTextSuffix: '&id=<?php echo $tvId ?>',
                    prevText: 'Prev',
                    nextText: 'Next',
                    ellipseText: '&hellip;',
                    cssStyle: 'light-theme',
                    selectOnClick: true,
                    onPageClick: function(pageNumber, event) {
                        // Callback triggered when a page is clicked
                        // Page number is given as an optional parameter
                    },
                    onInit: function() {
                        // Callback triggered immediately after initialization
                    }
                }, options || {});

                var self = this;

                o.pages = o.pages ? o.pages : Math.ceil(o.items / o.itemsOnPage) ? Math.ceil(o.items / o.itemsOnPage) : 1;
                o.currentPage = o.currentPage - 1;
                o.halfDisplayed = o.displayedPages / 2;

                this.each(function() {
                    self.addClass(o.cssStyle + ' simple-pagination').data('pagination', o);
                    methods._draw.call(self);
                });

                o.onInit();

                return this;
            },

            selectPage: function(page) {
                methods._selectPage.call(this, page - 1);
                return this;
            },

            prevPage: function() {
                var o = this.data('pagination');
                if (o.currentPage > 0) {
                    methods._selectPage.call(this, o.currentPage - 1);
                }
                return this;
            },

            nextPage: function() {
                var o = this.data('pagination');
                if (o.currentPage < o.pages - 1) {
                    methods._selectPage.call(this, o.currentPage + 1);
                }
                return this;
            },

            getPagesCount: function() {
                return this.data('pagination').pages;
            },

            getCurrentPage: function () {
                return this.data('pagination').currentPage + 1;
            },

            destroy: function(){
                this.empty();
                return this;
            },

            redraw: function(){
                methods._draw.call(this);
                return this;
            },

            disable: function(){
                var o = this.data('pagination');
                o.disabled = true;
                this.data('pagination', o);
                methods._draw.call(this);
                return this;
            },

            enable: function(){
                var o = this.data('pagination');
                o.disabled = false;
                this.data('pagination', o);
                methods._draw.call(this);
                return this;
            },

            updateItems: function (newItems) {
                var o = this.data('pagination');
                o.items = newItems;
                o.pages = Math.ceil(o.items / o.itemsOnPage) ? Math.ceil(o.items / o.itemsOnPage) : 1;
                this.data('pagination', o);
                methods._draw.call(this);
            },

            _draw: function() {
                var	o = this.data('pagination'),
                    interval = methods._getInterval(o),
                    i;

                methods.destroy.call(this);

                var $panel = this.prop("tagName") === "UL" ? this : $('<ul></ul>').appendTo(this);

                // Generate Prev link
                if (o.prevText) {
                    methods._appendItem.call(this, o.currentPage - 1, {text: o.prevText, classes: 'prev'});
                }

                // Generate start edges
                if (interval.start > 0 && o.edges > 0) {
                    var end = Math.min(o.edges, interval.start);
                    for (i = 0; i < end; i++) {
                        methods._appendItem.call(this, i);
                    }
                    if (o.edges < interval.start && (interval.start - o.edges != 1)) {
                        $panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
                    } else if (interval.start - o.edges == 1) {
                        methods._appendItem.call(this, o.edges);
                    }
                }

                // Generate interval links
                for (i = interval.start; i < interval.end; i++) {
                    methods._appendItem.call(this, i);
                }

                // Generate end edges
                if (interval.end < o.pages && o.edges > 0) {
                    if (o.pages - o.edges > interval.end && (o.pages - o.edges - interval.end != 1)) {
                        $panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
                    } else if (o.pages - o.edges - interval.end == 1) {
                        methods._appendItem.call(this, interval.end++);
                    }
                    var begin = Math.max(o.pages - o.edges, interval.end);
                    for (i = begin; i < o.pages; i++) {
                        methods._appendItem.call(this, i);
                    }
                }

                // Generate Next link
                if (o.nextText) {
                    methods._appendItem.call(this, o.currentPage + 1, {text: o.nextText, classes: 'next'});
                }
            },

            _getInterval: function(o) {
                return {
                    start: Math.ceil(o.currentPage > o.halfDisplayed ? Math.max(Math.min(o.currentPage - o.halfDisplayed, (o.pages - o.displayedPages)), 0) : 0),
                    end: Math.ceil(o.currentPage > o.halfDisplayed ? Math.min(o.currentPage + o.halfDisplayed, o.pages) : Math.min(o.displayedPages, o.pages))
                };
            },

            _appendItem: function(pageIndex, opts) {
                var self = this, options, $link, o = self.data('pagination'), $linkWrapper = $('<li></li>'), $ul = self.find('ul');

                pageIndex = pageIndex < 0 ? 0 : (pageIndex < o.pages ? pageIndex : o.pages - 1);

                options = $.extend({
                    text: pageIndex + 1,
                    classes: ''
                }, opts || {});

                if (pageIndex == o.currentPage || o.disabled) {
                    if (o.disabled) {
                        $linkWrapper.addClass('disabled');
                    } else {
                        $linkWrapper.addClass('active');
                    }
                    $link = $('<span class="current">' + (options.text) + '</span>');
                } else {
                    $link = $('<a href="' + o.hrefTextPrefix + (pageIndex + 1) + o.hrefTextSuffix + '" class="page-link">' + (options.text) + '</a>');
                    $link.click(function(event){
                        return methods._selectPage.call(self, pageIndex, event);
                    });
                }

                if (options.classes) {
                    $link.addClass(options.classes);
                }

                $linkWrapper.append($link);

                if ($ul.length) {
                    $ul.append($linkWrapper);
                } else {
                    self.append($linkWrapper);
                }
            },

            _selectPage: function(pageIndex, event) {
                var o = this.data('pagination');
                o.currentPage = pageIndex;
                if (o.selectOnClick) {
                    methods._draw.call(this);
                }
                return o.onPageClick(pageIndex + 1, event);
            }

        };

        $.fn.pagination = function(method) {

            // Method calling logic
            if (methods[method] && method.charAt(0) != '_') {
                return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
            } else if (typeof method === 'object' || !method) {
                return methods.init.apply(this, arguments);
            } else {
                $.error('Method ' +  method + ' does not exist on jQuery.pagination');
            }

        };

    })(jQuery);

    // jquery.pagination.file.custom end

    let items = $(".list-wrapper .list-item");
    let numItems = 10000;
    let perPage = 20;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            let showFrom = perPage * (pageNumber - 1);
            let showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });


</script>
</body>
</html>
<script>


</script>
