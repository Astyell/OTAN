<?php
	include ("fctAux.inc.php");
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
		header('Location: connexion.php');
		exit();
	}

	// Récupération des données
	$ID    = $_SESSION [   'id'];
	$droit = $_SESSION ['droit'];

	if ($droit != 1) 
	{
		header('Location: visualisation.php');
		exit();
	}
	enTete1_2();
	echo "<link rel='stylesheet' href='../css/header.css' type='text/css' />\n";
	echo "<link rel='stylesheet' href='../css/impoExp.css' type='text/css' />\n";
	echo "<title>Importer</title>";
	enTete2_2();
	// Afficher le header en fonction de l'utilisateur
	if ($droit) { incHeaderAdmin(); }
	else        { incHeaderUser (); }

	echo "<p class=\"titreP\"> Exporter </p>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<section class=\"encad\">\n";
	corps();
	echo "</section>\n";
	echo "<br>\n";
	pied();

	function corps()
	{
		// Fonction pour générer le tableau avec cases à cocher
		genererTableau();
		if(isset($_POST['valider'])) {
			// Boucle pour traiter les cases cochées
			for ($i = 0; $i < 6; $i++) {
				for ($j = 0; $j < 3; $j++) {
					// Vérifier si la case est cochée
					if(isset($_POST['commission_'.$i.'_'.$j])) {
						// Appeler la méthode associée
						//call_user_func(genererMethode());
						echo 'commission_'.$i.'_'.$j;
					}
					if(isset($_POST['jury_'.$i.'_'.$j])) {
						// Appeler la méthode associée
						//call_user_func(genererMethode());
						echo 'jury_'.$i.'_'.$j;
					}
				}
			}
		}
	}

	function genererTableau()
	{

		echo "<form method='post' action=''>\n";
		echo "<table >\n";
		for ($i = 1; $i < 7; $i++) {
			echo "<tr>\n<th >S".$i."</th > \n<th >Excel</th > \n<th >Word</th > \n<th >PDF</th >\n</tr>\n";
			echo "<tr>\n";
			// Première ligne
			echo "<td>fichier commission</td>\n";
			for ($j = 0; $j < 3; $j++) {
				echo "<td class='case'><input type='checkbox' class='caseC' name='commission_".$i."_".$j."'></td>\n";
			}
			// Deuxième ligne
			echo "</tr>\n<tr>\n";
			echo "<td>fichier jury</td>\n";
			for ($k = 0; $k < 3; $k++) {
				echo "<td class='case'><input type='checkbox' class='caseC' name='jury_".$i."_".$k."'></td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n<br>";
		echo "<input type=\"submit\" name=\"valider\" value=\"Valider\">\n";
		echo "</form>\n";
	}
	// Vérifier si le formulaire a été soumis
	
?>