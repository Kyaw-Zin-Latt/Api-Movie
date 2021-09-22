<?php
require_once "../template/header.php";
$data = file_get_contents("https://api.themoviedb.org/3/person/popular?api_key=30abe6e1b3cd32a7e8d4b5ee6b117400&language=en-US&page=1");
$popularPersons = json_decode($data);
$popularPersonsResult = $popularPersons->results;
//$popularPersonsResultKnownFor = $popularPersonsResult->known_for;
//
//
//
//print_r($popularPersonsResult->known_for);

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
                <div class="row">
                    <?php foreach ($popularPersonsResult as $row) { ?>
                        <div class="mb-4" style="width: 19.5%">

                            <div class="card h-100 rounded-3">
                                <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                    <img src="https://image.tmdb.org/t/p/w235_and_h235_face<?php echo $row->profile_path; ?>" class="rounded-3" alt="">
                                </a>
                                <div class="card-body">
                                    <a href="<?php echo $url; ?>/person/person_detail.php?person_id=<?php echo $row->id; ?>">
                                        <h5 class="card-title"><?php echo $row->name; ?></h5>
                                    </a>
<!--                                    --><?php //foreach ($row->known_for as $rowKnown){ ?>
<!--                                    <p class="card-text text-black-50">--><?php //echo $rowKnown->name; ?><!--</p>-->
<!--                                    --><?php //} ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<?php require_once "../template/footer.php"; ?>