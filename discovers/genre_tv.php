<?php
require_once "../template/header.php";
$genreId = $_GET['id'];
if (isset($_GET['page'])) {
    $pageNumber = $_GET['page'];
    $dataAction = file_get_contents("https://api.themoviedb.org/3/discover/tv?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=$pageNumber&with_genres=$genreId&with_watch_monetization_types=flatrate");

} elseif (isset($_GET['sort_by'])) {
    $sortKey = $_GET['sort_by'];
    $dataAction = file_get_contents("https://api.themoviedb.org/3/discover/tv?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sortKey&include_adult=false&include_video=false&page=1&with_genres=$genreId&with_watch_monetization_types=flatrate");
} else {
    $dataAction = file_get_contents("https://api.themoviedb.org/3/discover/tv?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=$genreId&with_watch_monetization_types=flatrate");

}

$dataGenresList = file_get_contents("https://api.themoviedb.org/3/genre/tv/list?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$dataGenresListArr = json_decode($dataGenresList);
$dataGenresListGenresArr = $dataGenresListArr->genres;

$dataActionArr = json_decode($dataAction);
$dataActionResultArr = $dataActionArr->results;


?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <div class="row bg-dark py-3">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <?php foreach ($dataGenresListGenresArr as $row){ ?>
                                <h2 class="text-primary <?php echo $row->id ==  $genreId ? 'd-block' : 'd-none' ?>"><?php echo $row->id ==  $genreId ? $row->name : "" ?></h2>
                            <?php } ?>
                            <h2 class="text-primary">
                                <?php echo $dataActionArr->total_results; ?> shows
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="m-0">
    <div class="row">
        <div class="col-12">
            <div class="d-flex my-2 justify-content-center align-items-center">
                <div class="dropdown">
                    <a class="btn me-2 btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Movies
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Movies</a></li>
                        <li><a class="dropdown-item" href="#">TV Shows</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Sort
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
                        <li>
                            <div class="btn-group dropend w-100">
                                <button type="button" class="w-100 btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Popularity
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?sort_by=popularity.asc&id=<?php echo $genreId; ?>">Ascending</a></li>
                                    <li><a class="dropdown-item" href="?sort_by=popularity.desc&id=<?php echo $genreId; ?>">Descending</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="btn-group dropend w-100">
                                <button type="button" class="w-100 btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Rating
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?sort_by=vote_average.desc&id=<?php echo $genreId; ?>">Ascending</a></li>
                                    <li><a class="dropdown-item" href="?sort_by=vote_average.asc&id=<?php echo $genreId; ?>">Descending</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="btn-group dropend w-100">
                                <button type="button" class="w-100 btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Release Date
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?sort_by=first_air_date.asc&id=<?php echo $genreId; ?>">Ascending</a></li>
                                    <li><a class="dropdown-item" href="?sort_by=first_air_date.desc&id=<?php echo $genreId; ?>">Descending</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr class="mt-0">
</div>

<div class="container">
    <div class="row list-wrapper">
        <?php foreach ($dataActionResultArr as $row){ ?>
            <div class="col-12">
                <div class="card mb-3">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-1">
                            <?php if (empty($row->poster_path)){ ?>
                                <a href="<?php echo $url; ?>/tv_shows/tv_shows_detail.php?id=<?php echo $row->id; ?>" ">
                                <div class="d-flex justify-content-center rounded-top align-items-center bg-secondary" style="height: 141px;">
                                    <img class="" src="https://img.icons8.com/material-outlined/40/000000/image.png"/>
                                </div>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo $url; ?>/tv_shows/tv_shows_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                    <img class="rounded-start img-fluid" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                </a>
                            <?php } ?>

                        </div>
                        <div class="col-md-11">
                            <div class="rounded card-body py-2">
                                <a href="<?php echo $url; ?>/tv_shows/tv_shows_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                    <h5 class="title card-title fw-bolder mb-0"><?php echo $row->name; ?></h5>
                                </a>
                                <p class="card-text text-black-50"><?php echo showDate($row->first_air_date); ?></p>
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
                    hrefTextSuffix: '&id=<?php echo $genreId ?>',
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
