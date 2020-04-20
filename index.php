<?php

    include 'header.php';

    ini_set('memory_limit', '-1');

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "GET"
    ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.covid19api.com/summary"
    ));

    $arrRes = json_decode(curl_exec($curl), true);

    var_dump($arrRes);

    include 'footer.php';

?>
