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

$Countries = $arrRes['Countries'];

$id = array();
foreach ($Countries as $key => $row){
    $id[$key] = $row['TotalConfirmed'];
}
array_multisort($id, SORT_DESC, $Countries);

?>

<body>
    <div class="container mt-5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <h1 class="display-4"><b>Situation globale</b></h1>
                <p class="lead mt-3">Nombre de décès: <?php print_r(number_format($arrRes['Global']['TotalDeaths'],0,".",",")); ?> personnes</p>
                <hr class="my-4">
                <p class="lead">Nombre de Cas: <?php print_r(number_format($arrRes['Global']['TotalConfirmed'],0,".",",")); ?> personnes</p>
                <hr class="my-4">
                <p class="lead">Nombre de patients guéris: <?php print_r(number_format($arrRes['Global']['TotalRecovered'],0,".",",")); ?> personnes</p>
                <hr class="my-4">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="text-center display-4"><b>Les 20 pays les plus touchés</b></h1>
            <p class="text-center"> Dernière mise à jour: <?php echo date("d-m-Y H:i:s", strtotime($Countries[0]['Date'])); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pays</th>
                    <th scope="col">Nombre de cas contaminés</th>
                    <th scope="col">Nombre de morts</th>
                    <th scope="col">Nombre de guéris</th>
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
                    </thead>
                    <tbody>
                    <?php for ($i=0; $i < 20; $i++){ ?>
                        <tr>
                            <th scope="row"><?php  print_r($i + 1) ?></th>
                            <td><?php  print_r($Countries[$i]['Country']) ?></td>
                            <td><?php  print_r(number_format($Countries[$i]['TotalConfirmed'],0,".",",")) ?></td>
                            <td><?php  print_r(number_format($Countries[$i]['TotalDeaths'],0,".",",")) ?></td>
                            <td><?php  print_r(number_format($Countries[$i]['TotalRecovered'],0,".",",")) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>