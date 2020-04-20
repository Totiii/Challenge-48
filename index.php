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

    var_dump($arrRes['Countries']);

    include 'footer.php';

?>
