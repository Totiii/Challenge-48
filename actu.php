<?php
include 'function.php';

include 'header.php';




$live_news = curl_url("http://newsapi.org/v2/top-headlines?country=fr&category=health&pageSize=6&apiKey=5a358c61c5134605a6a9e3169d9f5abb&query=coronavirus");
$economic_news = curl_url("http://newsapi.org/v2/top-headlines?country=fr&category=business&apiKey=5a358c61c5134605a6a9e3169d9f5abb&pageSize=5&q=coronavirus");
$sport_news = curl_url("http://newsapi.org/v2/top-headlines?country=fr&category=sports&apiKey=5a358c61c5134605a6a9e3169d9f5abb&pageSize=5&q=coronavirus");
$technology_news = curl_url("http://newsapi.org/v2/top-headlines?country=fr&category=technology&apiKey=5a358c61c5134605a6a9e3169d9f5abb&pageSize=5&q=covid");

$untrusted_sources = array("Jeanmarcmorandini.com");


?>
<div class="container-fluid mt-3">
    <div class="jumbotron">
        <h1><div class="spinner-grow text-danger display-4" role="status"></div> En direct</h1>
        <p class="lead">Dernières informations des médias français à propos du Coronavirus</p>
        <div class="row">
        <?php
        foreach ($live_news->articles as $news){
            if(!in_array($news->source->name, $untrusted_sources)){
            ?>
                <div class="col-sm-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $news->title ?></h5><span class="badge badge-light"><?= date("d-m-Y H:i:s", strtotime($news->publishedAt)); ?></span>
                            <p class="card-text"><?= $news->description != null?$news->description:$news->content ?></p>
                            <a href="<?= $news->url ?>" target="_blank" class="btn btn-primary">En savoir plus <i class="fa fa-external-link" aria-hidden="true"></i></a>
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
            <div class="card">
                <div class="card-header text-center">
                    Economie
                </div>
                <?php
                    foreach ($economic_news->articles as $news) {
                        ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $news->title ?></h5>
                            <p class="card-text"><?= $news->description != null?$news->description:$news->content ?></p>
                            <a href="<?= $news->url ?>" target="_blank" class="btn btn-primary">En savoir plus <i class="fa fa-external-link" aria-hidden="true"></i></a>
                        </div>
                <?php
                    }
                ?>
              <!--  <div class="card-footer text-muted">

                </div>-->
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-center">
                    Sport
                </div>
                <?php
                foreach ($sport_news->articles as $news) {
                    ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $news->title ?></h5>
                        <p class="card-text"><?= $news->description != null?$news->description:$news->content ?></p>
                        <a href="<?= $news->url ?>" target="_blank" class="btn btn-primary">En savoir plus <i class="fa fa-external-link" aria-hidden="true"></i></a>
                    </div>
                    <?php
                }
                ?>
                <!--  <div class="card-footer text-muted">

                  </div>-->
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header text-center">
                    Technologie
                </div>
                <?php
                foreach ($technology_news->articles as $news) {
                    ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $news->title ?></h5>
                        <p class="card-text"><?= $news->description != null?$news->description:$news->content ?></p>
                        <a href="<?= $news->url ?>" target="_blank" class="btn btn-primary">En savoir plus <i class="fa fa-external-link" aria-hidden="true"></i></a>
                    </div>
                    <?php
                }
                ?>
                <!--  <div class="card-footer text-muted">

                  </div>-->
            </div>
        </div>
    </div>

</div>


<?php include 'footer.php'; ?>
