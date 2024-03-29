<?php
	/** avis.php
	* @author  : Alizéa Lebaron, Sébastien Champvillard
	* @since   : 27/03/2024
	* @version : 1.1.0 - 29/03/2024
	*/

	// Affichage des erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Importation
	include ("fctAux.inc.php");
	require ("../../backend/php/DB/DB.inc.php");

	// Début de la session
    session_start();

	// Vérification que la session existe bien
	// if (!isset($_SESSION['id'])) 
	// {
    //     header('Location: connexion.php');
    //     exit();
    // }

	// Récupération des données
	// $ID    = $_SESSION [   'id'];
	// $droit = $_SESSION ['droit'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/avis.css">
	<link rel="stylesheet" href="../css/header.css">
	<title>O.T.A.N. - Avis de Poursuite d'Études</title>
</head>

<body>

	<?php
		incHeaderAdmin();

		incUpAvis ();
	?>


	<div class="A4">
	<div class="logos">
		<h1 class="left_logo"  >Logo1<img src="" alt="" id="logo1"></h1>
		<h1 class="right_logo" >Logo2<img src="" alt="" id="logo2"></h1>
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
	<h6 class="drt" id="signDept"> Signature et cachet <img src="" alt=""> </h6>
	
	</div>
</body>

</html>