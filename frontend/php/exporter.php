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
	//require '../../backend/php/GenerationAvis.php';

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
		header('Location: connexion.php');
		exit();
	}

	setcookie('pv', 'null', time() + 50, '/');
	setcookie('semestre', 'null', time() + 50, '/');
	setcookie('annee', 'null', time() + 50, '/');

	setcookie('annee2', 'null', time() + 50, '/');
	setcookie('netud', 'null', time() + 50, '/');

	// Récupération des données
	$ID    = $_SESSION [   'id'];
	$droit = $_SESSION ['droit'];

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
		header('Location: connexion.php');
		exit();
	}
	$db = DB::getInstance();
	$lstAnn = $db->getAllAnnee();
	$lstSem = $db->getAllSemestre();
	sort($lstAnn);
	sort($lstSem);
	iset($lstAnn, $lstSem, $db);
	enTete1_2();
	echo "\t \t<link rel='stylesheet' href='../css/header.css'  type='text/css' />\n";
	echo "\t \t<link rel='stylesheet' href='../css/impoExp.css' type='text/css'/>\n";
	echo "\t \t<link rel='stylesheet' href='../css/footer.css'  type='text/css' />\n";
	echo "\t \t<title>O.T.A.N. - Exporter</title>\n";
	enTete2_2();

	// Afficher le header en fonction de l'utilisateur
	if ($droit) { incHeaderAdmin(); }
	else        { incHeaderUser (); }

	echo "\n \t \t<h1>Exporter</h1>\n";
	echo "\t \t<section class=\"encad\">\n";
	genererTableau($lstAnn, $lstSem);
	echo "\t \t</section>\n";
	pied();
	echo "\n\t</body>\n</html>\n";



	function iset($lstAnn, $lstSem, $db)
	{
		if(isset($_POST['valider'])) {

			$anneeChoisie = isset($_POST['annee']) ? $_POST['annee'] : null;
			echo $anneeChoisie;
			
			if ($anneeChoisie === null && count($lstAnn) > 0) {
				$anneeChoisie = $lstAnn[0]->getId_annee();
			}
			foreach ($lstSem as $semestre) 
			{
				if ($semestre->getId_annee() == $anneeChoisie) //exportation des fichier lier au semestre
				{
					for ($j = 0; $j < 3; $j++) {
						if(isset($_POST['commission_'.$semestre->getId_semestre().'_'.$j])) { // exportation des fichiers commission
							if($j==0) //exportation des fichiers commission  au format excel
							{
								setcookie('pv', 'comm', time() + 50, '/');
								setcookie('semestre', $semestre->getId_semestre(), time() + 50, '/');
								setcookie('annee', $anneeChoisie, time() + 50, '/');
								
								header('Location: ../../backend/php/modele/createurFichier.php');
								exit();
							}
							if($j==1) { /*exportation des fichiers commission au format word */ }
							if($j==2) { /*exportation des fichiers commission au format PDF*/ }
						}
						if(isset($_POST['jury_'.$semestre->getId_semestre().'_'.$j])) {// exportation des fichiers jury
							if($j==0) //exportation des fichiers jury au format excel
							{
								setcookie('pv', 'jury', time() + 50, '/');
								setcookie('semestre', $semestre->getId_semestre(), time() + 50, '/');
								setcookie('annee', $anneeChoisie, time() + 50, '/');
								
								header('Location: ../../backend/php/modele/createurFichier.php');
								exit();
							}
							if($j==1) { /*exportation des fichiers jury au format word */ }
							if($j==2) { /*exportation des fichiers jury au format PDF*/ }
						}
					}
					for ($k = 0; $k < 2; $k++) {
						if(isset($_POST['AvisPoursuiteEtude_'.$k])) {
							if($k==0) { /*exportation des fichiers avis de poursuite d'étude au format word */ }
							if($k==1) //exportation des fichiers avis de poursuite d'étude au format PDF
							{ 
								AvisAllEtudiant($anneeChoisie, $db);
							}
						}
					}
				}
			}
		}
	}

	

	function genererTableau($lstAnn, $lstSem)
	{
		echo "\t \t \t<p> Veillez exporter les fichier un par un. </p><br>\n";
		echo "\t \t \t<form method='post' action=''>\n";
		echo "\t \t \t \t<label for=\"annee\">Sélectionner une année :</label>\n";
		echo "\t \t \t \t<select name=\"annee\">\n";

		$anneeChoisie = isset($_POST['annee']) ? $_POST['annee'] : null;
		$ann = $anneeChoisie;
		foreach ($lstAnn as $annee) {
			$selected = ($annee->getId_annee() == $anneeChoisie) ? 'selected' : '';
			echo "\t \t \t \t \t<option value='".$annee->getId_annee()."' $selected>".$annee->getId_annee()."</option>\n";
		}
		echo "\t \t \t \t</select>\n";
		echo "\t \t \t \t<input type=\"submit\" value=\"Consulter\">";
		echo "\t \t \t</form><br>";
		$anneeSelectionnee = isset($_POST['annee']) ? $_POST['annee'] : null;
		if ($anneeSelectionnee === null && count($lstAnn) > 0) {
			$anneeSelectionnee = $lstAnn[0]->getId_annee();
		}
		echo "\t \t \t<form method='post' action=''>\n";
		echo "\t \t \t \t<table >\n";

		foreach ($lstSem as $semestre) 
		{
			if ($semestre->getId_annee() == $anneeSelectionnee)
			{
				echo "\t \t \t \t \t<tr>\n\t \t \t \t \t \t<th >S".$semestre->getId_semestre()."</th > \n\t \t \t \t \t \t<th >Excel</th > \n\t \t \t \t \t \t<th >Word</th > \n\t \t \t \t \t \t<th >PDF</th >\n\t \t \t \t \t</tr>\n";
				echo "\t \t \t \t \t<tr>\n";
				echo "\t \t \t \t \t \t<td>fichier commission</td>\n";
				echo "\t \t \t \t \t \t<td class='case'><input type='checkbox' class='caseC' name='commission_".$semestre->getId_semestre()."_0'></td>\n";
				for ($j = 1; $j < 3; $j++) { echo "\t \t \t \t \t \t<td class='case'><input type='checkbox' class='caseInnac' name='commission_".$semestre->getId_semestre()."_".$j."' disabled></td>\n"; }
				echo "\t \t \t \t \t</tr>\n\t \t \t \t \t<tr>\n";
				echo "\t \t \t \t \t \t<td>fichier jury</td>\n";
				echo "\t \t \t \t \t \t<td class='case'><input type='checkbox' class='caseC' name='jury_".$semestre->getId_semestre()."_0'></td>\n";
				for ($k = 1; $k < 3; $k++) { echo "\t \t \t \t \t \t<td class='case'><input type='checkbox' class='caseInnac' name='jury_".$semestre->getId_semestre()."_".$k."' disabled></td>\n"; }
				echo "\t \t \t \t \t</tr>\n";
			}
		}
		echo "\t \t \t \t \t<tr>\n";
		echo "\t \t \t \t \t<tr >\n\t \t \t \t \t \t<th COLSPAN=2>Autre</th >  \n\t \t \t \t \t \t<th >Word</th > \n\t \t \t \t \t \t<th >PDF</th >\n\t \t \t \t \t</tr>\n";
		echo "\t \t \t \t \t \t<td COLSPAN=2>Avis de poursuite d'étude</td>\n";
		echo "\t \t \t \t \t \t<td class='case'><input type='checkbox' class='caseInnac' name='AvisPoursuiteEtude_0' disabled></td>\n";
		echo "\t \t \t \t \t \t<td class='case'><input type='checkbox' class='caseC' name='AvisPoursuiteEtude_1'></td>\n";
		echo "\t \t \t \t \t</tr>\n";
		echo "\t \t \t \t</table><br>\n";
		echo "\t \t \t \t<p>Attention, les avis de poursuite d'étude sont nominatifs et nécessitent de modifier le modèle en amont.</p><br>\n";
		echo "\t \t \t \t<input type=\"submit\" class=\"Valid\" name=\"valider\" value=\"Valider\">\n";
		echo "\t \t \t</form>\n";
	}

	function AvisAllEtudiant($annee, $db)
	{
		$etudiants = $db->getAllEtuSemWithSem(5, $annee);
		
		echo $etudiants;
		foreach($etudiants as $etudiant)
		{
			setcookie('annee2', $annee, time() + 50, '/');
			setcookie('netud', $etudiant->getN_Etud(), time() + 50, '/');

			header('Location: ../../backend/php/GenerationAvis.php');
			exit();
		}
		//genererAvis($annee, '8860');
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