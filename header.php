<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Coronavirus</title>

  <!-- Intégration icône du site -->
  <link rel="icon" type="image/png" href="./assets/img/logo16.png" />

  <!-- Integration de la detection d'écran portable [Responsive] -->
  <meta name="viewport" content="width=device-width, user-scalable=no">

  <!-- Integration des élements bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
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

  <!-- Intégration des icônes Font Awesome  + Material Icons -->
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

    <!-- Menu qui s'ouvre et se ferme en fonction de "ouvrirFermerMenu()" -->
	<div id="sideNavigation" class="sidenav">
        <a href="#"><i class="fa fa-tachometer"></i> Dashboard</a>
        <a href="#"><i class="fa fa-calendar"></i> Actualités</a>
        <a href="#"><i class="fa fa-heartbeat"></i> Préventions</a>
        <hr>
        <select class="barre_rechercher">
            </option value="ANGLAIS">FRANCAIS</option>
        </select>
	</div>

    <!-- Header principal -->
	<nav class="topnav">
        <!-- Menu normal pour les grands écrans -->
        <div class="menu_normal">
            <select class="barre_rechercher">
                <option value="ANGLAIS">FRANCAIS</option>
            </select>
            <a href="#"><i class="fa fa-tachometer"></i> Dashboard</a>
            <a href="#"><i class="fa fa-calendar"></i> Actualités</a>
            <a href="#"><i class="fa fa-heartbeat"></i> Préventions</a>
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