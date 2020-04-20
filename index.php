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

$totalDeath = $arrRes['Global']['TotalDeaths'];
$totalCases = $arrRes['Global']['TotalConfirmed'];
$totalRecovered = $arrRes['Global']['TotalRecovered'];

$Countries = $arrRes['Countries'];

$id = array();
foreach ($Countries as $key => $row){
    $id[$key] = $row['TotalConfirmed'];
}
array_multisort($id, SORT_DESC, $Countries);

include 'footer.php';

?>

<body>
    <div class="container mt-5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <h1 class="display-4"><b>Situation Globale</b></h1>
                <p class="lead mt-3">Nombres de déces: <?php print_r($totalDeath); ?> personnes</p>
                <hr class="my-4">
                <p class="lead">Nombres de Cas: <?php print_r($totalCases); ?> personnes</p>
                <hr class="my-4">
                <p class="lead">Nombres de patients guéris: <?php print_r($totalRecovered); ?> personnes</p>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center display-4"><b>Les 20 pays les plus touchés</b></h1>
                <p class="text-center"> Dernière mise à jour: <?php  print_r($Countries[0]['Date']); ?></p>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Pays</th>
                <th scope="col">Nombres de Cas</th>
                <th scope="col">Nombre de morts</th>
                <th scope="col">Nombre de gueris</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0; $i < 20; $i++){ ?>
            <tr>
                <th scope="row"><?php  print_r($i + 1) ?></th>
                <td><?php  print_r($Countries[$i]['Country']) ?></td>
                <td><?php  print_r($Countries[$i]['TotalConfirmed']) ?></td>
                <td><?php  print_r($Countries[$i]['TotalDeaths']) ?></td>
                <td><?php  print_r($Countries[$i]['TotalRecovered']) ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>

<script>

</script>
