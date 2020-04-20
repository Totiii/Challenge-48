<?php
include 'header.php';

function url_encode($string){
    $encode = str_replace(' ', '%20', $string);
    $encode = str_replace('(', '%28', $encode);
    $encode = str_replace(')', '%29', $encode);
    return $encode;
}

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

</div>

