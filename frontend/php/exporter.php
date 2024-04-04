<?php
	/** exporter.php
	* @author  : Justine BONDU, Matéo SA, Alizéa LEBARON
	* @since   : 29/03/2024
	* @version : 1.0.0 - 03/04/2024
	*/
	include ("fctAux.inc.php");
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	//require '../../backend/php/modele/createurFichier.php';
	include('../../backend/php/DB/DB.inc.php');

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
		header('Location: connexion.php');
		exit();
	}

	setcookie('pv', 'null', time() + 50, '/');
	setcookie('semestre', 'null', time() + 50, '/');
	setcookie('annee', 'null', time() + 50, '/');

	// Récupération des données
	$ID    = $_SESSION [   'id'];
	$droit = $_SESSION ['droit'];

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
		header('Location: connexion.php');
		exit();
	}
	iset();
	enTete1_2();
	echo "\t<link rel='stylesheet' href='../css/header.css'  type='text/css' />\n";
	echo "\t<link rel='stylesheet' href='../css/impoExp.css' type='text/css'/>\n";
	echo "\t<link rel='stylesheet' href='../css/footer.css'  type='text/css' />\n";
	echo "\t<title>O.T.A.N. - Exporter</title>\n";
	enTete2_2();

	// Afficher le header en fonction de l'utilisateur
	if ($droit) { incHeaderAdmin(); }
	else        { incHeaderUser (); }

	$db = DB::getInstance();
	$lstAnn = $db->getAllAnnee();
	$lstSem = $db->getAllSemestre();
	sort($lstAnn);
	sort($lstSem);
	echo "\t<h1>Exporter</h1>\n";
	echo "\t<section class=\"encad\">\n";
	genererTableau($lstAnn, $lstSem);
	echo "\t</section>\n";
	pied();
	echo "\t</body>\n</html>\n";



	function iset()
	{
		$anneeChoisie = 0;
		if(isset($_POST['valider'])) {
			$anneeChoisie = $_POST['annee'];
			for ($i = 1; $i < 7; $i++) {
				for ($j = 0; $j < 3; $j++) {
					if(isset($_POST['commission_'.$i.'_'.$j])) {
						//echo 'commission_'.$i.'_'.$j;
						//echo "<br>\n";
						//if( $j==0 ) { creerPvComm($i,$anneeChoisie); }
						if($j==0)
						{
							setcookie('pv', 'comm', time() + 50, '/');
							setcookie('semestre', $i, time() + 50, '/');
							setcookie('annee', $anneeChoisie, time() + 50, '/');
							
							header('Location: ../../backend/php/modele/createurFichier.php');
							exit();
						}
					}
					if(isset($_POST['jury_'.$i.'_'.$j])) {
						if($j==0)
						{
							setcookie('pv', 'jury', time() + 50, '/');
							setcookie('semestre', $i, time() + 50, '/');
							setcookie('annee', $anneeChoisie, time() + 50, '/');
							
							header('Location: ../../backend/php/modele/createurFichier.php');
							exit();
						}
					}
				}
			}
			for ($k = 0; $k < 2; $k++) {
				if(isset($_POST['AvisPoursuiteEtude_'.$k])) {
					echo 'AvisPoursuiteEtude_'.$k;
				}
			}
		}
	}

	function genererTableau($lstAnn, $lstSem)
	{
		echo "\t<p> Veillez exporter les fichier un par un. </p>\n<br>\n";
		echo "<form method='post' action=''>\n";
		echo "<label for=\"annee\">Sélectionner une année :</label>\n";
		echo "<select name=\"annee\">\n";
		foreach ($lstAnn as $annee) { echo "<option value='".$annee->getId_annee()."'>".$annee->getId_annee()."</option>\n"; }
		echo "</select>\n";
		echo "</select><input type=\"submit\" value=\"Consulter\">";
		echo "</form>\n<br><br>";
		$anneeSelectionnee = isset($_POST['annee']) ? $_POST['annee'] : null;
		if ($anneeSelectionnee === null && count($lstAnn) > 0) {
			$anneeSelectionnee = $lstAnn[0]->getId_annee();
		}
		echo "<form method='post' action=''>\n";
		echo "<table >\n";

		foreach ($lstSem as $semestre) 
		{
			if ($semestre->getId_annee() == $anneeSelectionnee)
			{
				echo "<tr>\n<th >S".$semestre->getId_semestre()."</th > \n<th >Excel</th > \n<th >Word</th > \n<th >PDF</th >\n</tr>\n";
				echo "<tr>\n";
				echo "<td>fichier commission</td>\n";
				echo "<td class='case'><input type='checkbox' class='caseC' name='commission_".$semestre->getId_semestre()."_0'></td>\n";
				for ($j = 1; $j < 3; $j++) { echo "<td class='case'><input type='checkbox' class='caseInnac' name='commission_".$semestre->getId_semestre()."_".$j."' disabled></td>\n"; }
				echo "</tr>\n<tr>\n";
				echo "<td>fichier jury</td>\n";
				echo "<td class='case'><input type='checkbox' class='caseC' name='jury_".$semestre->getId_semestre()."_0'></td>\n";
				for ($k = 1; $k < 3; $k++) { echo "<td class='case'><input type='checkbox' class='caseInnac' name='jury_".$semestre->getId_semestre()."_".$k."' disabled></td>\n"; }
				echo "</tr>\n";
			}
		}
		echo "<tr>\n";
		echo "<tr >\n<th COLSPAN=2>Autre</th >  \n<th >Word</th > \n<th >PDF</th >\n</tr>\n";
		echo "<td COLSPAN=2>Avis de poursuite d'étude</td>\n";
		echo "<td class='case'><input type='checkbox' class='caseInnac' name='AvisPoursuiteEtude_0' disabled></td>\n";
		echo "<td class='case'><input type='checkbox' class='caseC' name='AvisPoursuiteEtude_1'></td>\n";
		echo "</tr>\n";
		echo "</table>\n<br>\n";
		echo "Attention, les avis de poursuite d'étude sont nominatifs et nécessitent de modifier le modèle en amont.\n<br><br>\n";
		echo "<input type=\"submit\" class=\"Valid\" name=\"valider\" value=\"Valider\">\n";
		echo "</form>\n";
	}
	
?>
<script>
	
	const checkboxes = document.querySelectorAll('.caseC');

	checkboxes.forEach(checkbox => {
		checkbox.addEventListener('change', function() {
			if (this.checked) {
			// Désactivez toutes les autres cases et mettez en évidence la case cochée
			checkboxes.forEach(cb => {
				if (cb !== this) {
					cb.disabled = true;
					cb.parentElement.classList.remove('checked'); // Supprimer la classe 'checked' des autres cases
				}
			});
			this.parentElement.classList.add('checked'); // Ajouter la classe 'checked' à la case cochée
			} else {
				// Réactivez toutes les cases et supprimez la classe 'checked'
				checkboxes.forEach(cb => {
					cb.disabled = false;
					cb.parentElement.classList.remove('checked');
				});
			}
		});
	});
</script>
