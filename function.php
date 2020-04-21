<?php
function url_encode($string){
    $encode = str_replace(' ', '%20', $string);
    $encode = str_replace('(', '%28', $encode);
    $encode = str_replace(')', '%29', $encode);
    return $encode;
}

function curl_url($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res = json_decode(curl_exec($curl));
    curl_close($curl);
    return $res;

}


$apikey = "077a2c963e4541aba4753f854a8e0c99";
//$apikey = "5a358c61c5134605a6a9e3169d9f5abb";
?>