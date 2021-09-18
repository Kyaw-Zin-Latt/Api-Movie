<?php
require_once "../template/header.php";
$dataGenres = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US");
$genresArr = json_decode($dataGenres);
$genresArrResult = $genresArr->genres;
//if (isset($_GET['page'])) {
//    $pageNumber = $_GET['page'];
//    $data = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=$pageNumber");
//
//} else {
//    $data = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
//
//}

if (isset($_POST['sort_by'])) {

    if (isset($_POST['sort_by'])) {
        $sort_key = $_POST['sort_by'];
        $pageNumber = 1;
    } else {
        $sort_key = $_GET['sort_by'];
        $pageNumber = $_GET['page'];
    }
    $dataBySort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=$pageNumber&with_watch_monetization_types=flatrate");
    $sortMovies = json_decode($dataBySort);
    $sortMoviesResult = $sortMovies->results;
}else {
    $dataBySort = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&sort_by=$sort_key&include_adult=false&include_video=false&page=1&with_watch_monetization_types=flatrate");
    $sortMovies = json_decode($dataBySort);
    $sortMoviesResult = $sortMovies->results;
}

//$popularMovieArr = json_decode($data);
//$popularMovieArrResult = $popularMovieArr->results;



?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <div class="row">
        <div class="col-12">
            <h3 class="fw-bolder my-4">Popular Movies</h3>
        </div>
        <div class="col-3">
            <div class="accordion mb-3" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class=" accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h5 class="mb-0">Sort</h5>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h5 class="text-black-50">Sort Results By</h5>
                            <form action="" id="sort" method="post">
                                <select class="form-select" name="sort_by" aria-label="Default select example">
                                    <option value="popularity.desc" <?php echo $sort_key === "popularity.desc" ? "selected" : " " ?> >Popularity Descending</option>
                                    <option value="popularity.asc" <?php echo $sort_key === "popularity.asc" ? "selected" : " " ?> >Popularity Ascending</option>
                                    <option value="vote_average.desc" <?php echo $sort_key === "vote_average.desc" ? "selected" : " " ?> >Rating Descending</option>
                                    <option value="vote_average.asc" <?php echo $sort_key === "vote_average.asc" ? "selected" : " " ?> >Rating Ascending</option>
                                    <option value="primary_release_date.desc" <?php echo $sort_key === "primary_release_date.desc" ? "selected" : " " ?>> Release Date Descending</option>
                                    <option value="primary_release_date.asc" <?php echo $sort_key === "primary_release_date.asc" ? "selected" : " " ?> >Release Date Ascending</option>
                                    <option value="title.asc" <?php echo $sort_key === "title.asc" ? "selected" : " " ?> >Title (A-Z)</option>
                                    <option value="title.desc" <?php echo $sort_key === "title.desc" ? "selected" : " " ?> >Title (Z-A)</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button form="sort" class="w-100 border-secondary btn btn-light rounded-pill">Sort</button>

            <div class="accordion my-3" id="accordionExample1">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Filters
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample1">
                        <div class="accordion-body">
                            <h5 class="text-black-50">Search By Date</h5>
                            <form action="" id="filter" method="post">
                                <div class="mb-2">
                                    <label for="from" class="form-label">Start Date</label>
                                    <input type="date" name="start" value="<?php echo isset($start) ? $start : '' ; ?>" id="from" class="form-control">
                                </div>
                                <div class="">
                                    <label for="from" class="form-label">End Date</label>
                                    <input type="date" name="end" value="<?php echo isset($end) ? $end : '' ; ?>" id="from" class="form-control">
                                </div>
                                <hr>
                                <h5>Genres</h5>
                                <?php foreach ($genresArrResult as $row) { ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" name="genres[]" type="checkbox" id="inlineCheckbox<?php echo $row->id; ?>" value="<?php echo $row->id; ?>">
                                        <label class="form-check-label" for="inlineCheckbox<?php echo $row->id; ?>"><?php echo $row->name; ?></label>
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <button form="filter" class="w-100 border-secondary btn btn-light rounded-pill">Filter</button>
        </div>
        <div class="col-9">
            <div class="row list-wrapper">
                <?php if (isset($_POST['sort_by'])){ ?>

                    <?php foreach ($sortMoviesResult as $row) { ?>
                        <div class="mb-4" style="width: 19.5%">

                            <div class="card h-100 rounded-3">
                                <?php if (empty($row->poster_path)){ ?>
                                    <div class="">
                                        <h1><i class="fas fa-image"></i></h1>
                                    </div>

                                <?php } else { ?>
                                    <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                        <img src="https://image.tmdb.org/t/p/w500<?php echo $row->poster_path; ?>" class="rounded-3 card-img-top" alt="">
                                    </a>
                                <?php } ?>
                                <div class="card-body">
                                    <a href="">
                                        <h5 class="card-title"><?php echo $row->title; ?></h5>
                                    </a>
                                    <p class="card-text text-black-50"><?php echo showDate($row->release_date); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php } else { ?>
<!--                    --><?php //foreach ($popularMovieArrResult as $row) { ?>
<!--                        <div class="mb-4" style="width: 19.5%">-->
<!---->
<!--                            <div class="card h-100 rounded-3">-->
<!--                                --><?php //if (empty($row->poster_path)){ ?>
<!--                                    <a href="--><?php //echo $url; ?><!--/movies/movie_detail.php?id=--><?php //echo $row->id; ?><!--" ">-->
<!--                                    <img src="../assets/img/no-image.png" class="rounded-3 h-100 card-img-top" alt="">-->
<!--                                    </a>-->
<!--                                --><?php //} else { ?>
<!--                                    <a href="--><?php //echo $url; ?><!--/movies/movie_detail.php?id=--><?php //echo $row->id; ?><!--">-->
<!--                                        <img src="https://image.tmdb.org/t/p/w500--><?php //echo $row->poster_path; ?><!--" class="rounded-3 card-img-top" alt="">-->
<!--                                    </a>-->
<!--                                --><?php //} ?>
<!--                                <div class="card-body">-->
<!--                                    <a href="" class="title text-decoration-none text-dark">-->
<!--                                        <h5 class="card-title">--><?php //echo $row->title; ?><!--</h5>-->
<!--                                    </a>-->
<!--                                    <p class="card-text text-black-50">--><?php //echo showDate($row->release_date); ?><!--</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //} ?>
                <?php } ?>
                <div id="pagination-container" class="align-items-start mt-3 fs"></div>
            </div>
        </div>
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
                    hrefTextSuffix: '<?php echo isset($sort_key) ? "&sort_by=$sort_key" : " " ?>',
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

