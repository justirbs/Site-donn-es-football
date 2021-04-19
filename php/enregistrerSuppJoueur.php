<html>
<head>
	<title>Enregistrer Modifications Joueur</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
  <link rel="icon" type="image/png" href="../img/icon.png">
</head>
<body>

	<div id="navbar" class="navbar">
		<ul>
		  <li><a href="profilEntraineur.php">Profil</a></li>
		  <li><a class="active" href="gererJoueurs.php">Gérer les joueurs</a></li>
		  <li><a href="gererStatistiques.php">Gérer les statistiques</a></li>
		  <li style="float:right"><a href="./deconnexion.php?connexion=out">Déconexion</a></li>
		</ul>
	</div>

  <div class="affichage">

	  <?php

    /*Fonction pour supprimer le joueur dans le fichier infoJoueurs.csv*/

    function modifierFichier(){
      $row = 1;

      $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
      $joueur = explode(";", $_POST["joueur"]); // on récupère le nom et le prénom du joueur pour savoir quelle ligne supprimer

      // on ouvre le fichier csv
      if (($handle = fopen("../csv/infoJoueurs.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          for ($c=0; $c < $num; $c++) {
            // on récupère les données de chaque ligne
            $array = explode(";", $data[$c]);
            // si on n'est pas à la ligne du joueur à supprimer, on conserve les données dans le tableau
            if(($joueur[0] != $array[0]) || ($joueur[1] != $array[1])){
              array_push($donneesCsv, array($array[0], $array[1], $array[2], $array[3], $array[4]));
            }
          }
          $row++;
        }
        // on ferme et on supprime l'ancien csv
        fclose($handle);
        unlink("../csv/infoJoueurs.csv");
      }
      // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données et on le renomme comme l'ancien
      $fp = fopen("../csv/infoJoueurs2.csv", "a+");
      foreach ($donneesCsv as $joueur) {
        fputcsv($fp, $joueur, ";");
      }
      fclose($fp);
      rename("../csv/infoJoueurs2.csv", "../csv/infoJoueurs.csv");

    }

    // on modifie le fichier csv
    modifierFichier();

    $joueur = explode(";", $_POST["joueur"]);
    $nomCsv = "../csv/".$joueur[0].$joueur[1].".csv";

    //si le joueur a ses statistiques stockées dans un fichier, il faut le supprimer
    if(file_exists($nomCsv)){
      unlink($nomCsv);
    }

    echo("<h4>Le joueur ".$joueur[0]." ".$joueur[1]." a bien été supprimé !</h4>")

	  ?>
		<a href="supprimerJoueur.php">Revenir à la page précédente</a>
	</div>
</body>