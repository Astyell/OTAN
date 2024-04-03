<?php
	include ("fctAux.inc.php");
    session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require '../../backend/php/modele/createurFichier.php';

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
    echo "<link rel='stylesheet' href='../css/footer.css' type='text/css' />\n";
	echo "<title>O.T.A.N. - Exporter</title>";
	enTete2_2();
	// Afficher le header en fonction de l'utilisateur
	if ($droit) { incHeaderAdmin(); }
	else        { incHeaderUser (); }

	echo "<p class=\"titreP\"> Exporter </p>\n";
	echo "<br>\n";
	echo "<br>\n";
	$db = DB::getInstance();
	$lstAnn = $db->getAllAnnee();
	echo "<section class=\"encad\">\n";
	corps($lstAnn);
	echo "</section>\n";
	echo "<br>\n";
	pied();

	function corps($lstAnn)
	{
		genererTableau($lstAnn);
		$anneeChoisie = 0;
		if(isset($_POST['valider'])) {
			$anneeChoisie = $_POST['annee'];
			for ($i = 1; $i < 7; $i++) {
				for ($j = 0; $j < 3; $j++) {
					if(isset($_POST['commission_'.$i.'_'.$j])) {
						echo 'commission_'.$i.'_'.$j;
						echo "<br>\n";
						if( $j==0 ) { creerPvComm($i,$anneeChoisie); }
					}
					if(isset($_POST['jury_'.$i.'_'.$j])) {
						echo 'jury_'.$i.'_'.$j;
						echo "<br>\n";
					}
				}
			}
			for ($k = 0; $k < 2; $k++) {
				if(isset($_POST['AvisPoursuiteEtude_'.$k])) {
					echo 'AvisPoursuiteEtude_'.$k;
				}
			}
		}
        echo "</body>\n";
        echo "</html>\n";
	}

	function genererTableau($lstAnn)
	{
		echo "<form method='post' action=''>\n";
		echo "<label for=\"annee\">Sélectionner une année :</label>";
		echo "<select name=\"annee\">";
		foreach ($lstAnn as $annee) {
			echo "<option value='".$annee->getId_annee()."'>".$annee->getId_annee()."</option>\n";

		}
		echo "</select><br><br>";

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
		echo "<tr>\n";
		echo "<tr >\n<th COLSPAN=2>Autre</th >  \n<th >Word</th > \n<th >PDF</th >\n</tr>\n";
		echo "<td COLSPAN=2>Avis de poursuite d'étude</td>\n";
		for ($k = 0; $k < 2; $k++) {
			echo "<td class='case'><input type='checkbox' class='caseC' name='AvisPoursuiteEtude_".$k."'></td>\n";
		}
		echo "</tr>\n";
		echo "</table>\n<br>\n";
		echo "Attention, les avis de poursuite d'étude sont nominatifs et nécessitent de modifier le modèle en amont.\n<br><br>\n";
		echo "<input type=\"submit\" class=\"Valid\" name=\"valider\" value=\"Valider\">\n";
		echo "</form>\n";
	}
	
?>