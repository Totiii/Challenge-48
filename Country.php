<?php
include 'header.php';

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
$SlugPays =  $_GET['slug'];
$Countries = $arrRes['Countries'];

foreach ($Countries as $Country){
    if($Country['Slug'] == $SlugPays){
        $actualCountryGlobalStats = $Country;
    }
}

include 'footer.php';

?>

<body>
<div class="container mt-3">
    <div class="jumbotron jumbotron-fluid">
        <div class="container text-center">
            <h1 class="display-4"><b>Situation Globale en <?php print_r($actualCountryGlobalStats['Country']); ?></b></h1>
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

</body>

<script>

</script>

