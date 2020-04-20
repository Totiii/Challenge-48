<?php
include 'header.php';

function url_encode($string){
    $encode = str_replace(' ', '%20', $string);
    $encode = str_replace('(', '%28', $encode);
    $encode = str_replace(')', '%29', $encode);
    return $encode;
}
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
    $date[$key] = $row['Date'];
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
        $otherDates[$nb] = $row['Date'];
        $nb += 1;
    }
}

include 'footer.php';

?>



<div class="container mt-3">
    <div class="jumbotron jumbotron-fluid">
        <div class="container text-center">
            <h1 class="display-4"><b>Situation Globale : <?php print_r($actualCountryGlobalStats['Country']); ?></b></h1>
            <small>Dernière mise a jour : <?php print_r($actualCountryGlobalStats['Date']); ?></small>
            <p class="lead mt-3">Nombres de déces: <?php print_r($actualCountryGlobalStats['TotalDeaths']); ?> personnes</p>
            <hr class="my-4">
            <p class="lead">Nombres de Cas: <?php print_r($actualCountryGlobalStats['TotalConfirmed']); ?> personnes</p>
            <hr class="my-4">
            <p class="lead">Nombres de patients guéris: <?php print_r($actualCountryGlobalStats['TotalRecovered']); ?> personnes</p>
            <hr class="my-4">
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h5 class="text-center">Evolution du nombres de cas : <?php print_r($actualCountryGlobalStats["Country"]); ?></h5>
            <canvas id="ChartCase" class="mt-1"></canvas>
        </div>
        <div class="col mb-5">
            <h5 class="text-center">Dernieres statistiques : <?php print_r($actualCountryGlobalStats["Country"]); ?></h5>
            <canvas id="LatestStats" class="mt-1"></canvas>
        </div>
    </div>
</div>


<?php

echo Locale::getDisplayRegion('IT', 'fr');

$actu_contry = url_encode($actualCountryGlobalStats['Country']);

$url_contry_info = "https://restcountries.eu/rest/v2/name/".$actu_contry;
$curl_contry_info = curl_init();
curl_setopt($curl_contry_info, CURLOPT_URL, $url_contry_info);
curl_setopt($curl_contry_info, CURLOPT_RETURNTRANSFER, 1);
$res_contry_info = json_decode(curl_exec($curl_contry_info));
curl_close($curl_contry_info);
var_dump( $res_contry_info);
$contry_french_name = $res_contry_info[0]->translations->fr;
$contry_french_name_urlencoded = url_encode($res_contry_info[0]->translations->fr);

    $url_actu_contry = "http://newsapi.org/v2/everything?apiKey=5a358c61c5134605a6a9e3169d9f5abb&sortBy=publishedAt&qinTitle=%28%20coronavirus%20OR%20covid19%20%29%20AND%20".$actu_contry;
    $url_actu_contry_fr = "http://newsapi.org/v2/everything?apiKey=5a358c61c5134605a6a9e3169d9f5abb&sortBy=publishedAt&language=fr&qinTitle=%28%20coronavirus%20OR%20covid19%20%29%20AND%20".$contry_french_name_urlencoded;

    $curl_actu_contry_fr = curl_init();
    curl_setopt($curl_actu_contry_fr, CURLOPT_URL, $url_actu_contry_fr);
    curl_setopt($curl_actu_contry_fr, CURLOPT_RETURNTRANSFER, 1);
    $res_actu_contry_fr = json_decode(curl_exec($curl_actu_contry_fr));
    curl_close($curl_actu_contry_fr);
    $nb_result_fr = $res_actu_contry_fr->totalResults;
    $nb_result_all_lg = $nb_result_fr;
var_dump($res_actu_contry_fr);
    if($nb_result_fr <= 3){
        //aucun resutat fr
        $curl_actu_contry = curl_init();
        curl_setopt($curl_actu_contry, CURLOPT_URL, $url_actu_contry);
        curl_setopt($curl_actu_contry, CURLOPT_RETURNTRANSFER, 1);
        $res_actu_contry = json_decode(curl_exec($curl_actu_contry));
        curl_close($curl_actu_contry);

        $nb_result_all_lg += $res_actu_contry->totalResults;

    }

    var_dump($res_actu_contry);

?>

<div class="container">

    <?php

        if($nb_result_all_lg > 0){



        }else{
            ?>
    <div class="alert alert-primary" role="alert">
        Aucun article de presse à propos du coronavirus en rapport avec ce pays n'a été trouvé.
        <a href="https://google.fr/search?q=coronavirus%20en%20<?= $actu_contry ?>" target="_blank">Rechercher sur Google</a>
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
                label: 'Nombres de cas',
                data: cases,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
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
                label: 'Nombre de morts en <?php print_r($actualCountryGlobalStats["Country"]); ?> ',
                data: deaths,
                fill: false,
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            },
                {
                    label: 'Nombre de soignées en <?php print_r($actualCountryGlobalStats["Country"]); ?> ',
                    data: recovered,
                    fill: false,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Nombre de cas confirmer en <?php print_r($actualCountryGlobalStats["Country"]); ?> ',
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

</script>

