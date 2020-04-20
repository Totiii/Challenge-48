<?php

include 'header.php';


$url_api = "http://newsapi.org/v2/everything?apiKey=5a358c61c5134605a6a9e3169d9f5abb&qinTitle=coronavirus%20OR%20covid19&language=fr&sortBy=popularity";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url_api);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
curl_close($curl);



$headline_url = "http://newsapi.org/v2/top-headlines?country=fr&category=health&apiKey=5a358c61c5134605a6a9e3169d9f5abb&query=coronavirus";
$curl_headline = curl_init();
curl_setopt($curl_headline, CURLOPT_URL, $headline_url);
curl_setopt($curl_headline, CURLOPT_RETURNTRANSFER, 1);
$live_news = json_decode(curl_exec($curl_headline));
curl_close($curl_headline);


?>
<div class="container mt-3">
    <div class="jumbotron">
        <h1><div class="spinner-grow text-danger display-4" role="status"></div> En direct</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <div class="row">
        <?php
        foreach ($live_news->articles as $news){
            if($news->source->name != "Jeanmarcmorandini.com"){
            ?>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $news->title ?></h5>
                            <p class="card-text"><?= $news->description != null?$news->description:$news->content ?></p>
                            <a href="<?= $news->url ?>" target="_blank" class="btn btn-primary">En savoir plus</a>
                        </div>
                    </div>
                </div>

        <?php }  }  ?>
        </div>
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