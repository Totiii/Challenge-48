<?php

include 'header.php';


$url_api = "http://newsapi.org/v2/everything?apiKey=5a358c61c5134605a6a9e3169d9f5abb&qinTitle=coronavirus%20OR%20covid19&language=fr&sortBy=popularity";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url_api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
curl_close($curl);

?>
<div class="container mt-3">
    <div class="jumbotron">
        <h1><div class="spinner-grow text-danger display-4" role="status"></div> En direct</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </div>

</div>

<div class="container-fluid">

    <div class="row">
        <div class="col">
            sdf
        </div>
        <div class="col">
sdf
        </div>
        <div class="col">
sdf
        </div>
    </div>

</div>


<?php include 'footer.php'; ?>
