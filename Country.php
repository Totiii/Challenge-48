<?php
include 'function.php';

include 'header.php';


$curl = curl_init();
$curl2 = curl_init();
$curl3 = curl_init();
$SlugPays =  $_GET['slug'];

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER, 1,
    CURLOPT_URL => "https://api.covid19api.com/summary"
));

$arrRes = json_decode(curl_exec($curl), true);
$Countries = $arrRes['Countries'];
date_default_timezone_set('UTC');
$today = date("Y-m-y");

foreach ($Countries as $Country){
    if($Country['Slug'] == $SlugPays){
        $actualCountryGlobalStats = $Country;
    }
}

curl_setopt_array($curl2, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER, 1,
    CURLOPT_URL => "https://api.covid19api.com/total/country/".$SlugPays."/status/confirmed?from=2020-03-01T00:00:00Z&to=".$today."T00:00:00Z"
));

$arrRes2 = json_decode(curl_exec($curl2), true);

$date = array();
foreach ($arrRes2 as $key => $row){
    $date[$key] = date("d-m-Y", strtotime($row['Date']));
}

$cases = array();
foreach ($arrRes2 as $key => $row){
    $cases[$key] = $row['Cases'];
}

curl_setopt_array($curl3, array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_RETURNTRANSFER, 1,
    CURLOPT_URL => "https://api.covid19api.com/live/country/".$SlugPays."/status/confirmed"
));
$arrRes3 = json_decode(curl_exec($curl3), true);

$i = 0;
$n = 0;
$b = 0;
$nb = 0;

$confirmed = array();
foreach ($arrRes3 as $key => $row){
    if ($row['Province'] == ""){
        $confirmed[$i] = $row['Confirmed'];
        $i += 1;
    }
}

$deaths = array();
foreach ($arrRes3 as $key => $row){
    if ($row['Province'] == ""){
        $deaths[$n] = $row['Deaths'];
        $n += 1;
    }
}

$recovered = array();
foreach ($arrRes3 as $key => $row){
    if ($row['Province'] == ""){
        $recovered[$b] = $row['Recovered'];
        $b += 1;
    }
}

$otherDates = array();
foreach ($arrRes3 as $key => $row){
    if ($row['Province'] == ""){
        $otherDates[$nb] = date("d-m-Y", strtotime($row['Date']));
        $nb += 1;
    }
}

$actu_contry = $actualCountryGlobalStats['Country'];
$actu_contry_code = $actualCountryGlobalStats["CountryCode"];

$res_contry_info = curl_url("https://restcountries.eu/rest/v2/alpha/".$actu_contry_code);

$contry_french_name = $res_contry_info->translations->fr;
$contry_french_name_urlencoded = url_encode($res_contry_info->translations->fr);
$contry_name_urlencoded = url_encode($res_contry_info->nativeName);

?>



<div class="container mt-3">
    <div class="jumbotron jumbotron-fluid">
        <div class="container text-center">
            <h1 class="display-4"><b>Situation globale : <?= $contry_french_name ?></b> <img class="img-fluid" width="65" src="<?= $res_contry_info->flag ?>" alt="Drapeau"></h1>
            <small>Dernière mise a jour : <?= $actualCountryGlobalStats['Date']; ?></small>
            <p class="lead mt-3">Nombre de décès: <b><span class="count"><?= $actualCountryGlobalStats['TotalDeaths']; ?></span></b> personnes</p>
            <hr class="my-4">
            <p class="lead">Nombre de cas: <b><span class="count"><?= $actualCountryGlobalStats['TotalConfirmed']; ?></span></b> personnes</p>
            <hr class="my-4">
            <p class="lead">Nombre de patients guéris: <b><span class="count"><?= $actualCountryGlobalStats['TotalRecovered']; ?></span></b> personnes</p>
            <hr class="my-4">
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h5 class="text-center">Evolution du nombre de cas : <?= $contry_french_name ?></h5>
            <canvas id="ChartCase" class="mt-1"></canvas>
        </div>
        <div class="col mb-5">
            <h5 class="text-center">Dernières statistiques : <?= $contry_french_name ?></h5>
            <canvas id="LatestStats" class="mt-1"></canvas>
        </div>
    </div>
</div>


<?php


    $actu_country_fr = curl_url("http://newsapi.org/v2/everything?apiKey=".$apikey."&pageSize=15&sortBy=publishedAt&language=fr&qinTitle=%28%20coronavirus%20OR%20covid19%20%29%20AND%20".$contry_french_name_urlencoded);


    $nb_result_fr = count($actu_country_fr->articles);
    $nb_result_all_lg = $nb_result_fr;
    //var_dump($actu_country_fr);
    if($nb_result_fr <= 10){
        //aucun resutat fr
        $nb_to_search = 15 - $nb_result_fr;
        $actu_country_alllang = curl_url("http://newsapi.org/v2/everything?apiKey=".$apikey."&pageSize=".$nb_to_search."&sortBy=publishedAt&qinTitle=%28%20coronavirus%20OR%20covid19%20%29%20AND%20".$contry_name_urlencoded);
        $nb_result_all_lg += $actu_country_alllang->totalResults;
        //var_dump($actu_country_alllang);
    }



?>

<div class="container">

    <?php

        if($nb_result_all_lg > 0){
            if($nb_result_fr > 0 ){
                echo $nb_result_fr;

                foreach ($actu_country_fr->articles as $news){
                    echo $news->title;
                }

            }else{
                ?>
                <div class="alert alert-primary" role="alert">
                    Aucun article de presse en français à propos du coronavirus en rapport avec ce pays n'a été trouvé.
                    <a href="https://google.fr/search?q=coronavirus%20en%20<?= $contry_french_name ?>" target="_blank">Rechercher sur Google</a>
                </div>
                <?php
            }
            foreach ($actu_country_alllang->articles as $news){
                echo $news->title;
            }



        }else{
            ?>
    <div class="alert alert-primary" role="alert">
        Aucun article de presse à propos du coronavirus en rapport avec ce pays n'a été trouvé.
        <a href="https://google.fr/search?q=Coronavirus%20<?= $contry_french_name ?>" target="_blank">Rechercher sur Google</a>
    </div>
    <?php
        }
    ?>

<script>
    var dates = [];
    var cases = [];
    var confirmed = [];
    var deaths = [];
    var recovered = [];
    var otherDates = [];

    <?php
    for ($i=0; $i < sizeof($date); $i++){ ?>
    dates.push("<?php print_r($date[$i]) ?>")
    <?php
    }
    for ($i=0; $i < sizeof($cases); $i++){ ?>
    cases.push("<?php print_r($cases[$i]) ?>")
    <?php
    } ?>

    var ctx = document.getElementById('ChartCase').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Nombre de cas',
                data: cases,
                borderColor: [
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    <?php
    for ($i=0; $i < sizeof($confirmed); $i++){?>
    confirmed.push("<?php print_r($confirmed[$i]) ?>")
    <?php
    }
    for ($i=0; $i < sizeof($deaths); $i++){ ?>
    deaths.push("<?php print_r($deaths[$i]) ?>")
    <?php
    }
    for ($i=0; $i < sizeof($recovered); $i++){ ?>
    recovered.push("<?php print_r($recovered[$i]) ?>")
    <?php
    }
    for ($i=0; $i < sizeof($otherDates); $i++){ ?>
    otherDates.push("<?php print_r($otherDates[$i]) ?>")
    <?php
    }
    ?>

    var ctx = document.getElementById('LatestStats').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: otherDates,
            datasets: [{
                label: 'Nombre de morts en <?= $contry_french_name ?> ',
                data: deaths,
                fill: false,
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            },
                {
                    label: 'Nombre de soignés en <?= $contry_french_name ?> ',
                    data: recovered,
                    fill: false,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Nombre de cas confirmés en <?= $contry_french_name ?> ',
                    data: confirmed,
                    fill: false,
                    borderColor: [
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

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


</script>

