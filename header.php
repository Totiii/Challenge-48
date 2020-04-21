<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>CoroBoard</title>

  <!-- Intégration icône du site -->
  <link rel="icon" type="image/png" href="./assets/img/favicon.ico" />

  <!-- Integration de la detection d'écran portable [Responsive] -->
  <meta name="viewport" content="width=device-width, user-scalable=no">

  <!-- Integration des élements bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <!-- Integration css personalisé -->  
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/header.css">

  <!-- Chart js-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">


  <!-- Intégrtion js personnalisé -->
  <script src="assets/js/scripts.js"></script>
    <script src="assets/js/tablesorter.js"></script>

  <!-- Intégration des icônes Font Awesome  + Material Icons -->
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

    <?php

        error_reporting(E_ERROR | E_PARSE);

        include 'country-translate.php';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.covid19api.com/countries",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER, 1
        ));

        $arrRes = json_decode(curl_exec($curl), true);

        $country = array();
        foreach ($arrRes as $key => &$row){
            $row['Country'] = code_to_country($row['Country']);
            $country[$key] = $row['Country'];
        }
        array_multisort($country, SORT_ASC, $arrRes);

    ?>

    <!-- Menu qui s'ouvre et se ferme en fonction de "ouvrirFermerMenu()" -->
	<div id="sideNavigation" class="sidenav">
        <a href="index.php"><i class="fa fa-home"></i> Accueil</a>
        <a href="./actu.php"><i class="fa fa-newspaper-o"></i> Actualités</a>
        <a href="prevention.php"><i class="fa fa-heartbeat"></i> Prévention</a>
        <hr>
        <select id="countrySelectMob" class="barre_rechercher" onchange="goSearchMob()">
            <option selected>Rechercher par pays</option>
            <?php
                foreach ($arrRes as $oneCountry){
                    echo "<option value='" . $oneCountry['Slug'] . "'>" . $oneCountry['Country'] . "</option>";
                }
            ?>
        </select>
	</div>

    <!-- Header principal -->
	<nav class="topnav">
        <!-- Menu normal pour les grands écrans -->
        <div class="menu_normal">
            <select id="countrySelect" class="barre_rechercher" onchange="goSearch()">
                <option selected>Rechercher par pays</option>
                <?php
                    foreach ($arrRes as $oneCountry){
                        echo "<option value='" . $oneCountry['Slug'] . "'>" . $oneCountry['Country'] . "</option>";
                    }
                ?>
            </select>
            <a href="index.php"><i class="fa fa-home"></i> Accueil</a>
            <a href="./actu.php"><i class="fa fa-newspaper-o"></i> Actualités</a>
            <a href="prevention.php"><i class="fa fa-heartbeat"></i> Prévention</a>
         </div>

        <!-- Menu normal pour les écrans portables -->
        <div class="menu_burger">
            <a href="#" onclick="ouvrirFermerMenu()">
                <svg width="30" height="30" id="icoOpen">
                    <path d="M0,5 30,5" stroke="#FFF" stroke-width="5"/>
                    <path d="M0,14 30,14" stroke="#FFF" stroke-width="5"/>
                    <path d="M0,23 30,23" stroke="#FFF" stroke-width="5"/>
                </svg>
            </a>
        </div>
	</nav>

<div id="divFermeMenu" class="divFermeMenu" onclick="ouvrirFermerMenu()"></div>