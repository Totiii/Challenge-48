<?php

include 'header.php';

include 'function.php';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER, 1
));

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.covid19api.com/summary"
));

$arrRes = json_decode(curl_exec($curl), true);

$Countries = $arrRes['Countries'];

if(sizeof($Countries) == 0){
    die("L'API a rencontré une erreur, réésayer dans quelques instants");
}

$id = array();
foreach ($Countries as $key => $row){
    $id[$key] = $row['TotalConfirmed'];
}
array_multisort($id, SORT_DESC, $Countries);

$live_news = curl_url("http://newsapi.org/v2/top-headlines?country=fr&category=health&pageSize=6&apiKey=".$apikey."&query=coronavirus");

?>


    <div class="container mt-5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <h1 class="display-4"><b>Situation globale dans le monde</b></h1>
                <small>Dernière mise a jour : <?= date("d-m-Y H:i:s", strtotime($arrRes['Countries'][0]['Date'])); ?></small>
                <p class="lead mt-3">Nombre de décès: <b><span class="count"><?= $arrRes['Global']['TotalDeaths']; ?></span></b> personnes</p>
                <hr class="my-4">
                <p class="lead">Nombre de cas: <b><span class="count"><?= $arrRes['Global']['TotalConfirmed']; ?></span></b> personnes</p>
                <hr class="my-4">
                <p class="lead">Nombre de patients guéris: <b><span class="count"><?= $arrRes['Global']['TotalRecovered']; ?></span></b> personnes</p>
            </div>
        </div>
    </div>
    <div id="carouselExampleControls" class="carousel slide bg-light p-4 mb-3  text-center" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            for ($i = 0; $i < 5; $i++){
                if($i == 0){ ?>
                    <div class="carousel-item active">
                <?php } else { ?>
                    <div class="carousel-item">
                <?php } ?>
                <h5 class="text-center"><?= $live_news->articles[$i]->title ?></h5>
                        <a href="<?= $live_news->articles[$i]->url ?>" target="_blank"><img class="d-block mx-auto" src="<?= $live_news->articles[$i]->urlToImage ?>" style="height: 500px;"></a>

                </div>
            <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <a href="actu.php" class="btn btn-primary mt-2"><i class="fa fa-eye"></i>Voir plus d'actualités</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center display-4"><b>Les 20 pays les plus touchés</b></h1>
                <p class="text-center"> Dernière mise à jour: <?php echo date("d-m-Y H:i:s", strtotime($Countries[0]['Date'])); ?></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <table id="countries" class="table table-striped text-center">
                    <thead>
                    <tr>
                        <th scope="col"><i class="fa fa-sort"></i>#</th>
                        <th scope="col"><i class="fa fa-sort"></i>Pays</th>
                        <th scope="col"><i class="fa fa-sort"></i>Nombre de cas contaminés</th>
                        <th scope="col"><i class="fa fa-sort"></i>Nombre de morts</th>
                        <th scope="col"><i class="fa fa-sort"></i>Nombre de guéris</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i < 20; $i++){ ?>
                            <tr class="table-row" data-href="Country.php?slug=<?= $Countries[$i]['Slug'] ?>">
                                <th scope="row"><?php  print_r($i + 1) ?></th>
                                <td><a href="./Country.php?slug=<?= code_to_country($Countries[$i]['Slug']) ?>"><?= code_to_country($Countries[$i]['Country']) ?></a></td>
                                <td><?= number_format($Countries[$i]['TotalConfirmed'],0,".","") ?></td>
                                <td><?= number_format($Countries[$i]['TotalDeaths'],0,".","") ?></td>
                                <td><?= number_format($Countries[$i]['TotalRecovered'],0,".","") ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    $('.count').each(function () {
        let nb = $(this).text().replace(/,/g, '');
        $(this).prop('Counter',0).animate({
            Counter: nb
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(numberWithSpaces(Math.ceil(now)));
            }
        });
    });

    $("#countries").tablesorter({
        sortList: [1]
    });

</script>


<?php include 'footer.php' ?>