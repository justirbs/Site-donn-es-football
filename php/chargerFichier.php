<?php
session_start();
?>
<html>
<head>
	<title>Charger fichier</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
	<link rel="icon" type="image/png" href="../img/icon.png">
</head>
<body>

	<div id="navbar" class="navbar">
		<ul>
		  <li><a href="profilAdmin.php">Profil</a></li>
		  <li><a class="active" href="./gererClubs.php">Gérer les clubs</a></li>
		  <li style="float:right"><a href="./deconnexion.php?connexion=out">Déconexion</a></li>
		</ul>
	</div>

	<div class="titre">
		<h1>Charger un fichier</h1>
	</div>

  <div class="affichage">

  <?php
    /*Fonction pour récupérer les clubs dans clubs.csv*/
    function construireTabClubs(){
      $row = 1;
      $tabClubs = array();
      if (($handle = fopen("../csv/clubs.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          for ($c=0; $c < $num; $c++) {
            array_push($tabClubs, $data[$c]);
          }
          $row++;
        }
        fclose($handle);
      }
      return($tabClubs);
    }

    /*Fonction pour afficher le tableau avec tous les clubs*/
    function afficherTabClubs(){
      $tabClubs = construireTabClubs();
      echo("<h4>Les clubs sont désormais :</h4>
      <ul>");
      foreach ($tabClubs as $club) {
        echo("<li>".$club."</li>");
      }
      echo("</ul><br/>");
    }

    /*Fonction pour vérifier que le fichier csv est au bon format*/
    function verifierBonFormat($fichier){
      $row = 1;
      $estBonFormat = 1;
      if (($handle = fopen($fichier, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          for ($c=0; $c < $num; $c++) {
            $array = explode(";", $data[$c]);
            if((sizeof($array) != 1) || ($array[0] == "")){
              $estBonFormat = 0;
            }
          }
          $row++;
        }
        fclose($handle);
      }
      return($estBonFormat);
    }


    $target_dir = "../csv/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // on vérifie que le fichier n'a pas le même nom que l'ancien
    if (file_exists($target_file)) {
      $target_file = $target_file."2";
    }

    // on vérifie qu'il n'est pas trop lourd
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo("<h4>Le fichier est trop lourd ...</h4>");
      $uploadOk = 0;
    }

    // on vérifie que c'est bien un fichier .csv
    if($fileType != "csv") {
      echo("<h4>Nous n'acceptons que les fichier avec l'extension : .csv</h4>");
      $uploadOk = 0;
    }

    // on vérifie qu'il n'y a pas eu d'erreur
    if ($uploadOk == 0) {
      echo("<h4>Le fichier n'a pa pu être chargé...</h4>");
    // si tout est bon, on charge le fichier
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        // si le fichier a bien été chargé, on vérifie qu'il est au bon format
        if(verifierBonFormat($target_file)){
          echo("<h4>Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a bien été chargé !</h4>");
          // on supprime l'ancien et on le remplace par le nouveau
          unlink("../csv/clubs.csv");
          rename($target_file, "../csv/clubs.csv");
          afficherTabClubs();
        } else {
          echo("<h4>Ce fichier n'est pas au bon format, il n'a pas pu être chargé...</h4>");
          unlink($target_file);
        }


      } else {
        echo("<h4>Il y a eu une erreur lors du chargement du fichier...</h4>");
      }
    }
  ?>

    <a href="gererClubs.php">Retour à la page précédente</a>
  </div>


</body>