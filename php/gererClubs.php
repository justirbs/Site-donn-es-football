<?php
session_start();
?>
<html>
<head>
	<title>Gérer Clubs</title>
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
		<h1>Gérer les clubs</h1>
	</div>

	<div class="affichage">
		<h4>Les clubs sont actuellement :</h4>

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

		  $tabClubs = construireTabClubs();

		  echo("<ul>");
		  foreach ($tabClubs as $club) {
		    echo("<li>".$club."</li>");
		  }
			echo("</ul><br/>");

		  ?>
		<h4>Pour modifier les clubs, vous pouvez télécharger un nouveau fichier csv contenant les noms des clubs de votre choix</h4>
		<p>/!\ Le fichier csv doit respecter un certain format : exactement 1 club sur chaque ligne ! (pas aucun et pas plusieurs)</p>
	</div>

	<form id="formulaire" method="post" action="chargerFichier.php" class="formulaire" enctype="multipart/form-data" style="margin-top: 15px">
    <p>Sélectionnez le fichier à charger</p>
		<input type="file" name="fileToUpload" id="fileToUpload">
  	<p><input type="submit" value="Valider" class="btn" name="submit"/></p>
  </form>

</body>