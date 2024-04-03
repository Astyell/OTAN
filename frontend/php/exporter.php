<?php
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel='stylesheet' href='../css/header.css'  type='text/css' />
	<link rel='stylesheet' href='../css/impoExp.css' type='text/css'/>
	<link rel='stylesheet' href='../css/footer.css'  type='text/css' />

	<title>O.T.A.N. - Exporter</title>
</head>

<body>

	<?php
		// Afficher le header en fonction de l'utilisateur
		if ($droit) { incHeaderAdmin(); }
		else        { incHeaderUser (); }

		$db = DB::getInstance();
		$lstAnn = $db->getAllAnnee();
	?>

	<h1>Exporter</h1>

	<section class="encad">

		<?php
			genererTableau($lstAnn);
		?>

	</section>

	<?php
		pied();
	?>

	
</body>

</html>

<?php

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
						//echo 'jury_'.$i.'_'.$j;
						//echo "<br>\n";
					//if( $j==0 ) { /*creerPvJury($i,$anneeChoisie);*/ }
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

	function genererTableau($lstAnn)
	{
		echo "<p> Veillez exporter les fichier un par un. </p>";
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
