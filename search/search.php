<?php
require_once "../template/header.php";

if (isset($_GET['query'])) {
    $search_key = $_GET['query'];
    $pageNumber = $_GET['page'];

    $dataMovieSearch = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&query=$search_key&page=$pageNumber&include_adult=false");
    $dataTVSearch = file_get_contents("https://api.themoviedb.org/3/search/tv?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&query=$search_key&page=$pageNumber&include_adult=false");
    $dataPeopleSearch = file_get_contents("https://api.themoviedb.org/3/search/person?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&query=$search_key&page=$pageNumber&include_adult=false");
} else {
    $search_key = urlencode($_POST['query']);
    $dataMovieSearch = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&query=$search_key&page=1&include_adult=false");
    $dataTVSearch = file_get_contents("https://api.themoviedb.org/3/search/tv?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&query=$search_key&page=1&include_adult=false");
    $dataPeopleSearch = file_get_contents("https://api.themoviedb.org/3/search/person?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&query=$search_key&page=1&include_adult=false");
}




$MovieSearchArr = json_decode($dataMovieSearch);
$TVSearchArr = json_decode($dataTVSearch);
$PeopleSearchArr = json_decode($dataPeopleSearch);

$MovieSearchResultArr = $MovieSearchArr->results;
$TVSearchResultArr = $TVSearchArr->results;
$PeopleSearchResultArr = $PeopleSearchArr->results;

//print_r($search_key);

?>


<div class="container-fluid">
    <div class="row">
        <!--        navbar start        -->
        <?php require_once "../components/navbar.php"; ?>
        <!--        navbar end          -->
    </div>
    <div class="row my-4">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="card rounded-3">
                            <div class="card-header bg-dark text-light">
                                <h4 class="mb-0 py-3">Search Results</h4>
                            </div>
                            <div class="">
                                <div class="list-group rounded-0" id="list-tab" role="tablist">
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action active" id="list-trailer-list" data-bs-toggle="list" href="#movie" role="tab" aria-controls="list-trailer">
                                        Movies
                                        <span class="badge rounded-pill bg-secondary">
                                            <?php echo $MovieSearchArr->total_results; ?>
                                        </span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-teaser-list" data-bs-toggle="list" href="#tv" role="tab" aria-controls="list-teaser">
                                        TV Shows
                                        <span class="badge rounded-pill bg-secondary"><?php echo $TVSearchArr->total_results; ?></span>
                                    </a>
                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-clip-list" data-bs-toggle="list" href="#people" role="tab" aria-controls="list-clip">
                                        People
                                        <span class="badge rounded-pill bg-secondary"><?php echo $PeopleSearchArr->total_results; ?></span>
                                    </a>
<!--                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-behind-list" data-bs-toggle="list" href="#list-behind" role="tab" aria-controls="list-behind">-->
<!--                                        Collections-->
<!--                                        <span class="badge rounded-pill bg-secondary"></span>-->
<!--                                    </a>-->
<!--                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-blooper-list" data-bs-toggle="list" href="#list-blooper" role="tab" aria-controls="list-blooper">-->
<!--                                        Companies-->
<!--                                        <span class="badge rounded-pill bg-secondary"></span>-->
<!--                                    </a>-->
<!--                                    <a class="d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="list-featurette-list" data-bs-toggle="list" href="#list-featurette" role="tab" aria-controls="list-featurette">-->
<!--                                        Featurettes-->
<!--                                        <span class="badge rounded-pill bg-secondary"></span>-->
<!--                                    </a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="movie" role="tabpanel" aria-labelledby="list-trailer-list">
                                <div class="row list-wrapper">
                                    <?php if (countTotal($MovieSearchResultArr) > 0){ ?>

                                        <?php foreach ($MovieSearchResultArr as $row){ ?>

                                            <div class="card mb-3 shadow">
                                                <div class="row g-0">
                                                    <div class="col-md-2">
                                                        <a href="<?php ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                                            <?php if ($row->poster_path == null){ ?>
                                                                <div class="d-flex justify-content-center rounded-start align-items-center bg-secondary mb-0" style="height: 141px; width: 94px">
                                                                    <img class="" src="https://img.icons8.com/material-outlined/40/000000/image.png"/>
                                                                </div>
                                                            <?php } else {  ?>
                                                                <img class="rounded-start img-fluid h-100" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                            <?php } ?>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="rounded-start card-body py-2">
                                                            <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                <h5 class="title card-title fw-bolder mb-0"><?php echo $row->title; ?></h5>
                                                            </a>
                                                            <p class="card-text text-black-50"><?php echo showDate($row->release_date); ?></p>
                                                            <p class="card-text"><?php echo short($row->overview,150); ?> <?php echo (strlen($row->overview) >= 250) ? "..." : " " ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <p class="alert alert-warning text-dark">There are no Movies that matched your query.</p>

                                    <?php } ?>
                                    <div id="pagination-container" class="align-items-start mt-3 fs"></div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tv" role="tabpanel" aria-labelledby="list-teaser-list">
                                <div class="list-wrapper">
                                    <?php if (countTotal($TVSearchResultArr) > 0){ ?>

                                        <?php foreach ($TVSearchResultArr as $row){ ?>

                                            <div class="card mb-3 shadow">
                                                <div class="row g-0">
                                                    <div class="col-md-2">
                                                        <a href="<?php ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>">
                                                            <?php if ($row->poster_path == null){ ?>
                                                                <div class="d-flex justify-content-center rounded-start align-items-center bg-secondary mb-0" style="height: 141px; width: 94px">
                                                                    <img class="" src="https://img.icons8.com/material-outlined/40/000000/image.png"/>
                                                                </div>
                                                            <?php } else {  ?>
                                                                <img class="rounded-start img-fluid h-100" src="https://image.tmdb.org/t/p/w94_and_h141_bestv2<?php echo $row->poster_path; ?>" alt="">
                                                            <?php } ?>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="rounded-start card-body py-2">
                                                            <a href="<?php echo $url; ?>/movies/movie_detail.php?id=<?php echo $row->id; ?>" class="text-black text-decoration-none">
                                                                <h5 class="title card-title fw-bolder mb-0"><?php echo $row->name; ?></h5>
                                                            </a>
                                                            <p class="card-text text-black-50"><?php echo showDate($row->first_air_date); ?></p>
                                                            <p class="card-text"><?php echo short($row->overview,150); ?> <?php echo (strlen($row->overview) >= 250) ? "..." : " " ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>

                                    <?php } else { ?>

                                        <p class="alert alert-warning text-dark">There are no TVs that matched your query.</p>

                                    <?php } ?>
                                    <div id="pagination-container" class="align-items-start mt-3 fs"></div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="people" role="tabpanel" aria-labelledby="list-clip-list">
                                <ol>
                                    <?php foreach ($PeopleSearchResultArr as $row) { ?>
                                        <li class="list-group-item d-flex align-items-center">
                                            <?php if (empty($row->profile_path)){ ?>
                                                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                    <img class="rounded-3 profile-64-img border border-info p-2" src="<?php echo $url; ?>/assets/img/person.jpg" alt="">
                                                </a>

                                            <?php } else { ?>
                                                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                                    <img class="rounded-3" src="https://image.tmdb.org/t/p/w66_and_h66_face<?php echo $row->profile_path; ?>" alt="">
                                                </a>
                                            <?php } ?>

                                            <div class="ms-2">
                                                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>" class="text-decoration-none text-black">
                                                    <p class="mb-0 c-hover fw-bolder"><?php echo $row->name; ?> </p>
                                                </a>
                                                <div class="d-flex">
                                                    <p class="mb-0 text-black-50 mb-0"><?php echo isset($row->known_for_department) ? $row->known_for_department : "Acting" ?> <span class="mx-2 text-black fw-bolder"> .</span> </p>

                                                    <p class="mb-0">
                                                        <?php
                                                        $result = '';
                                                        foreach($row->known_for as $row) {
                                                            if (isset($row->title)) {
                                                                $result .= $row->title .' , ';
                                                            } else {
                                                                $result .= $row->name .' , ';
                                                            }
                                                        }
                                                        $result = rtrim($result,' , ');
                                                        echo $result;
                                                        ?>
                                                    </p>

                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
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
                    hrefTextSuffix: '&query=<?php echo $search_key;?>',
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
    let result = "";
    $(".list-group-item").click(function () {
       result = $(this).attr("href");
    })

    let items = $(".list-wrapper .list-item");
    let numItems = <?php echo $MovieSearchArr->total_results; ?>;
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

