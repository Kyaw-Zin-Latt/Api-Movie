<?php
require_once "../template/header.php";


if (isset($_GET['page'])) {
    $pageNumber = $_GET['page'];
    $data = file_get_contents("https://api.themoviedb.org/3/person/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=$pageNumber");
} else {
    $data = file_get_contents("https://api.themoviedb.org/3/person/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
}

$popularPersons = json_decode($data);
$popularPersonsResult = $popularPersons->results;

?>


    <div class="container-fluid">
        <div class="row">
            <!--        navbar start        -->
            <?php require_once "../components/navbar.php"; ?>
            <!--        navbar end          -->
        </div>
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bolder my-4">Popular People</h3>
            </div>
            <div class="col-12">
                <div class="row g-1 list-wrapper">
                    <?php foreach ($popularPersonsResult as $row) { ?>
                        <div class="mb-4" style="width: 20%">

                            <div class="card h-100 rounded-3">
                                <?php if (empty($row->profile_path)){ ?>
                                    <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                        <div class="d-flex justify-content-center img-fluid rounded-3 align-items-center bg-secondary" style="height: 240px; width: 235px">
                                            <img class="" src="https://img.icons8.com/material-rounded/180/000000/person-male.png"/>
                                        </div>
                                    </a>

                                <?php } else { ?>
                                    <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                        <img src="https://image.tmdb.org/t/p/w235_and_h235_face<?php echo $row->profile_path; ?>" class="rounded-3 w-100" alt="">
                                    </a>
                                <?php } ?>

                                <div class="card-body">
                                    <a class="text-decoration-none text-black c-hover" href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                        <h5 class="card-title"><?php echo $row->name; ?></h5>
                                    </a>
<!--                                    --><?php //foreach ($row->known_for as $rowKnown){ ?>
<!--                                    <p class="card-text text-black-50">--><?php //echo $rowKnown->name; ?><!--</p>-->
<!--                                    --><?php //} ?>
                                </div>
                            </div>
                        </div>
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
                    displayedPages:<?php echo $popularPersons->total_pages; ?>,
                    edges: 2,
                    currentPage: 0,
                    hrefTextPrefix: '?page=',
                    hrefTextSuffix:'',
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
    let numItems = <?php echo $popularPersons->total_results; ?>;
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
