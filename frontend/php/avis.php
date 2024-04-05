<?php
	/** avis.php
	* @author  : Alizéa Lebaron, Sébastien Champvillard
	* @since   : 27/03/2024
	* @version : 1.2.1 - 03/04/2024
	*/

	// Début de la session
    session_start();

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
        header('Location: connexion.php');
        exit();
    }

	// Reload la page à chaque fois pour les images
	header("Cache-Control: no-cache, must-revalidate");

	// Affichage des erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Importation
	include ("fctAux.inc.php");
	require ("../../backend/php/DB/DB.inc.php");

	// Récupération des données
	$ID    = $_SESSION [   'id'];
	$droit = $_SESSION ['droit'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/avis.css">
	<link rel='stylesheet' href='../css/footer.css' type='text/css' />
	<link rel="stylesheet" href="../css/header.css">
	<title>O.T.A.N. - Avis de Poursuite d'Études</title>
</head>

<body>

	<?php
		// Afficher le header en fonction de l'utilisateur
		if ($droit) { incHeaderAdmin(); }
		else        { incHeaderUser (); }

		// Ajout de la modification

		if ($droit) {incUpAvis ();}

		//Gestion des réponses du formulaire
		
		// On vérifie que l'on a bien reçu un formulaire
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			// On vérifie ensuite qu'il y a bien au moins une donnée dans ce formulaire
			if (!empty($_FILES['logo1']['type']) || !empty($_FILES['logo2']['type']) || !empty($_POST['anneeProm']) || !empty($_POST['nomChef']) || !empty($_FILES['signChefDep']['type'])) 
			{
				$data = array(
					'logo1' => isset($_FILES['logo1']['name']) && $_FILES['logo1']['name'] !== "" ? $_FILES['logo1']['name'] : null,
					'logo2' => isset($_FILES['logo2']['name']) && $_FILES['logo2']['name'] !== "" ? $_FILES['logo2']['name'] : null,
					'anneeProm' => $_POST['anneeProm'],
					'nomChef' => $_POST['nomChef'],
					'signChefDep' => isset($_FILES['signChefDep']['name']) && $_FILES['signChefDep']['name'] !== "" ? $_FILES['signChefDep']['name'] : null
				);

				// Convertir les données en format JSON
				$json_data = json_encode($data);

				// Chemin vers le fichier JSON
				$file_path = '../js/avis.json';
		
				// Écrire les données JSON dans le fichier
				file_put_contents($file_path, $json_data);
				
				// Il faut maintenant télécharger les images pour pouvoir les utiliser

				// Vérifier si les fichiers sont bien dans le formulaire
				if (isset($_FILES['logo1']      ['tmp_name'])) { downloadImage ("logo1");       }  
				if (isset($_FILES['logo2']      ['tmp_name'])) { downloadImage ("logo2");       }  
				if (isset($_FILES['signChefDep']['tmp_name'])) { downloadImage ("signChefDep"); }


			}
		}

	?>


	<div class="A4">
	<div class="logos">
		<h6 class="left_logo" id="logoG" > Logo 1</h6>
		<h6 class="right_logo" id="logoD" > Logo 2</h6>
	</div> 

	<br><br><br>
	<div class="titre">
		<h4>Fiche Avis Poursuite d'Études - Promotion <b id="annee">2021 - 2022</b> <br>
			Département Informatique IUT Le Havre</h4>
	</div>


	<h5>FICHE D'INFORMATION ÉTUDIANT(E)</h5>
	<hr>

	<table class="tabletop">
		<tbody>
			<tr class="Nom-Prenom">
				<td class="refTD"> Nom-Prénom</td>
				<td class="GrefTD" colspan="6"> </td>
			</tr>
			<tr class="Apprentissage">
				<td>Apprentissage : (oui/non)</td>
				<td>BUT-1</td>
				<td class="tdGrand"></td>
				<td>BUT-2</td>
				<td class="tdGrand"></td>
				<td>BUT-3</td>
				<td class="tdGrand"></td>
			</tr>
			<tr class="Parcours-etude">
				<td>Parcours d'études :</td>
				<td>n-2</td>
				<td class="tdGrand"></td>
				<td>n-1</td>
				<td class="tdGrand"></td>
				<td>n</td>
				<td class="tdGrand"></td>
			</tr>
			<tr class="Parcours-BUT">
				<td>Parcours BUT</td>
				<td colspan="6"> A « Réalisation d'applications : conception, développement, validation »</td>
			</tr>
			<tr class="mobilite">
				<td>Si mobilité à l'étranger (lieu, durée)</td>
				<td colspan="6"></td>
			</tr>
		</tbody>

	</table>

	<h5>RÉSULTATS DES COMPÉTENCES</h5>
	<hr>

	<table class="BUT12">
		<tbody>
			<tr>
				<td class="fantom"></td>

				<td colspan="2" class="grisG">BUT 1</td>
				<td colspan="2" class="grisG">BUT 2</td>
			</tr>
			<tr>
				<td class="fantom"></td>

				<td class="grisP">Moy</td>
				<td class="grisP">Rang</td>
				<td class="grisP">Moy</td>
				<td class="grisP">Rang</td>
			</tr>
			<tr>
				<td>UE1 - Réaliser des applications</td>

				<td class="tdPetit"></td>
				<td class="tdPetit"></td>
				<td class="tdPetit"></td>
				<td class="tdPetit"></td>
			</tr>
			<tr>
				<td>UE2 - Optimiser des applications</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>UE3 - Administrer des systèmes</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>UE4 - Gérer des données</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>UE5 - Conduire des projets</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>UE6 - Collaborer</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Maths</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Anglais</td>

				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Nombre d'absences injustifiées</td>

				<td colspan="2"></td>
				<td colspan="2"></td>

			</tr>
		</tbody>
	</table>

	<br>

	<table class="BUT12">
		<tbody>
			
			<tr>
				<td class="fantom">

				<td colspan="2" class="grisG">BUT 3 - S5</td> 
				
				
			</tr>
			<tr>
				<td class="fantom"></td>

				<td class="grisP">Moy</td>
				<td class="grisP">Rang</td>
				
			</tr>
			<tr>
				<td>UE1 - Réaliser des applications</td>

				<td class="tdGrand"></td> 
				<td class="tdGrand"></td>
				
			</tr>
			<tr>
				<td>UE2 - Optimiser des applications</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>UE3 - Administrer des systèmes</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>UE4 - Gérer des données</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>UE5 - Conduire des projets</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>UE6 - Collaborer</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>Maths</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>Anglais</td>

				<td></td>
				<td></td>
				
			</tr>
			<tr>
				<td>Nombre d'absences injustifiées</td>

				<td colspan="2"></td>
				

			</tr>
		</tbody>
	</table>

	<h5 class="txtCent">Avis de l'équipe pédagogique pour la poursuite d'études après le BUT3</h5>
	<hr>


	<table class="tableAvis">
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td>Très Favorable</td>
				<td>Favorable</td>
				<td>Assez Favorable</td>
				<td>Sans avis</td>
				<td>Réservé</td>
			</tr>
			<tr>
				<td rowspan="2">Pour l'étudiant</td>
				<td>En école d'ingénieurs</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>En master</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td rowspan="2">Nombre d'avis pour la promotion (total : XX)</td>
				<td>En école d'ingénieurs</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>En master</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="comm">Commentaire</td>
				<td colspan="6"></td>
			</tr>
		</tbody>
	</table>

	<h6 class="drt"              > Signature du chef de Département        </h6>
	<h6 class="drt" id="chefDept"> Nom du chef de Dept                     </h6>
	<h6 class="signature" id="signDept" > Signature et cachet                     </h6>
	
	</div>

	<?php
		pied();
	?>

	<script src="../js/avis.js"></script>

</body>

</html>