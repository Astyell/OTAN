<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin = (__DIR__ . "/../DB/DB.inc.php");
require $chemin;


$db = DB::getInstance();

function rechercheRang($ne,$s,$annee,$comp) : ?int
{
	global $db;
	$etus = $db -> getRangWithComp($s,$annee,$comp);
	for ($i=0; $i < count($etus) ; $i++) { 
		if ($etus[$i]->getN_Etud() == $ne) { return $i+1;}
	}
	return null;
}

function ficheAvis($annee, $nEtud, $imagePath1, $imagePath2, $imagePath3)
{
	global $db;

	$noteComp = $db->getAllNoteCompOrder($annee);

	$etudiant = $db->getEtudiantEtud($nEtud)[0];


	$moyUe = array();

	for($i=0;$i<20;$i++)
		$moyUe[$i] = 0;

	$resS1 = array();
	$resS2 = array();
	$nbS1 = 0;
	$nbS2 = 0;
	for ($s=2; $s < 7; $s+=2) 
	{ 
		$competences = $db->getCompetencesForSemestre($s);
		$oCompetences= $db->getCompetencesForSemestre($s-1);
		
		
		
		foreach ($noteComp as $note) 
		{
			if ($note->getN_Etud() == $nEtud) //Si c'est le bon etudiant
			{
				for($cpt=0;$cpt < count($competences);$cpt++)
				{
					
					if ($note->getId_competence() == $oCompetences[$cpt]->getId_competence()) //Si c'est la bonne compétence
					{
						$resS1[$nbS1++] = $note->getMoy_UE();
						//echo "1";
					}			
					
					if ($note->getId_competence() == $competences[$cpt]->getId_competence()) //Si c'est la bonne compétence
					{
						$resS2[$nbS2++] = $note->getMoy_UE();
						//echo "2";
					}		
				}	
			}
		}
		

	}

	for ($cpt=0;$cpt < $nbS1;$cpt++)
	{
		$moyUe[$cpt] = ($resS1[$cpt] + $resS2[$cpt])/2;
		//echo $moyUe[$cpt] . " | ";
	}
	
	
	
	return '
	
			
			<div class="A4">
			<div class="logos">
			<img src="data:image/jpeg;base64,' . $imagePath1 . '" alt="logo 1" class="left_logo" id="logoG" >
			<img src="data:image/jpeg;base64,' . $imagePath2 . '" alt="logo 2" class="right_logo" id="logoD" >
			</div> 

			<br><br><br>
			<div class="titre">
				<h4>Fiche Avis Poursuite d\'Études - Promotion <b id="annee">' . $annee . ' - ' . ($annee+1) .'</b> <br>
					Département Informatique IUT Le Havre</h4>
			</div>


			<h5>FICHE D\'INFORMATION ÉTUDIANT(E)</h5>
			<hr>

			<table class="tabletop">
				<tbody>
					<tr class="Nom-Prenom">
						<td class="refTD"> Nom-Prénom</td>
						<td class="GrefTD" colspan="6"> ' . $etudiant->getNom_Etu() . ' ' . $etudiant->getPrenom_Etu() . ' </td>
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
						<td>Parcours d\'études :</td>
						<td>n-2</td>
						<td class="tdGrand"></td>
						<td>n-1</td>
						<td class="tdGrand"></td>
						<td>n</td>
						<td class="tdGrand"></td>
					</tr>
					<tr class="Parcours-BUT">
						<td>Parcours BUT</td>
						<td colspan="6"> A « Réalisation d\'applications : conception, développement, validation »</td>
					</tr>
					<tr class="mobilite">
						<td>Si mobilité à l\'étranger (lieu, durée)</td>
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

						<td class="tdPetit"> ' 	. $moyUe[0].' </td>
						<td class="tdPetit"> ' 	. rechercheRang($nEtud,2,$annee,"BIN11") . '/' . count($db->getAllEtuSemWithSem(2,$annee)) .' </td>
						<td class="tdPetit">' 	. $moyUe[0] .'</td>
						<td class="tdPetit">' 	. rechercheRang($nEtud,4,$annee,"BIN21") . '/' . count($db->getAllEtuSemWithSem(4,$annee)) .' </td>
					</tr>
					<tr>
						<td>UE2 - Optimiser des applications</td>

						<td>' . $moyUe[0].'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN12") . '/' . count($db->getAllEtuSemWithSem(2,$annee)) .'</td>
						<td>' . $moyUe[6] .'</td>
						<td>' . rechercheRang($nEtud,4,$annee,"BIN22") . '/' . count($db->getAllEtuSemWithSem(4,$annee)) .'</td>
					</tr>
					<tr>
						<td>UE3 - Administrer des systèmes</td>

						<td>' . $moyUe[1].'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN13") . '/' . count($db->getAllEtuSemWithSem(2,$annee)) .'</td>
						<td>' . $moyUe[7] .'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN23") . '/' . count($db->getAllEtuSemWithSem(4,$annee)) .'</td>
					</tr>
					<tr>
						<td>UE4 - Gérer des données</td>

						<td>' . $moyUe[2].'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN14") . '/' . count($db->getAllEtuSemWithSem(2,$annee)) .'</td>
						<td>' . $moyUe[8] .'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN24") . '/' . count($db->getAllEtuSemWithSem(4,$annee)) .'</td>
					</tr>
					<tr>
						<td>UE5 - Conduire des projets</td>

						<td>' . $moyUe[4].'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN15") . '/' . count($db->getAllEtuSemWithSem(2,$annee)) .'</td>
						<td>' . $moyUe[10] .'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN25") . '/' . count($db->getAllEtuSemWithSem(4,$annee)) .'</td>
					</tr>
					<tr>
						<td>UE6 - Collaborer</td>

						<td>' . $moyUe[5].'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN16") . '/' . count($db->getAllEtuSemWithSem(2,$annee)) .'</td>
						<td>' . $moyUe[11] .'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN26") . '/' . count($db->getAllEtuSemWithSem(4,$annee)) .'</td>
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
						<td>Nombre d\'absences injustifiées</td>

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

						<td class="tdGrand">' .$moyUe[12].'</td> 
						<td class="tdGrand">' .rechercheRang($nEtud,2,$annee,"BIN51") . '/' . count($db->getAllEtuSemWithSem(5,$annee)) .'</td>
						
					</tr>
					<tr>
						<td>UE2 - Optimiser des applications</td>

						<td>' . $moyUe[13].'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN52") . '/' . count($db->getAllEtuSemWithSem(5,$annee)) .'</td>
						
						
					</tr>
					<tr>
						<td>UE3 - Administrer des systèmes</td>

						<td>' .'</td>
						<td>'  .'</td>
						
					</tr>
					<tr>
						<td>UE4 - Gérer des données</td>

						<td>'  .'</td>
						<td>'  .'</td>
						
					</tr>
					<tr>
						<td>UE5 - Conduire des projets</td>

						<td>'  .'</td>
						<td>'  .'</td>
						
					</tr>
					<tr>
						<td>UE6 - Collaborer</td>

						<td>' . $moyUe[14] .'</td>
						<td>' . rechercheRang($nEtud,2,$annee,"BIN56") . '/' . count($db->getAllEtuSemWithSem(5,$annee)) .'</td>
						
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
						<td>Nombre d\'absences injustifiées</td>

						<td colspan="2"></td>
						

					</tr>
				</tbody>
			</table>

			<h5 class="txtCent">Avis de l\'équipe pédagogique pour la poursuite d\'études après le BUT3</h5>
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
						<td rowspan="2">Pour l\'étudiant</td>
						<td>En école d\'ingénieurs</td>
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
						<td rowspan="2">Nombre d\'avis pour la promotion (total : XX)</td>
						<td>En école d\'ingénieurs</td>
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
			<h6 class="signature" id="signDept" ><img src="data:image/jpeg;base64,' . $imagePath3 . '" alt="signature dep" class="logo"></h6>			
			</div>
		';
}

function getTop()
{
	return '<!DOCTYPE html>
	<html lang="fr">
	
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../../../frontend/css/avis.css">
		<title>O.T.A.N. - Avis de Poursuite d\'Études</title>
	</head>
	
		<body>';
}

function getBot()
{
	return '</body>

	</html>
	
	<style>
		html, body
		{
			margin: 0;
			padding: 10px;
			font-size: 14px;
		}
		#modifier 
		{
			width: 250mm;
			margin: 0 auto;
			margin-top: 2vh;
			padding: 10px;
			border: 1px dotted black;
			background-color: #ffffff;
		}
		.modifTitre
		{
			text-align: center;
		}
		hr
		{
			margin-top: 0%;
		}
		.refTD
		{
			width: 250px;
		}
		.GrefTD
		{
			width: 650px;
		}
		table, th, td 
		{
			border: 1px solid black;
			border-collapse: collapse;
			font-size: 13px;
		}
		.tdGrand
		{
			min-width: 80px;
		}
		.tdPetit
		{
			min-width: 60px;
		}
		.left_logo
		{
			float: left;
			width: 100px;
			height: 100px;
		}
		.right_logo
		{
			padding-left: 30px;
			float: right;
			width: 50px;
			height: 50px;
		}
		.drt
		{
			margin-bottom: 5px;
			text-align: right;
		}
		.signature
		{
			margin: 0px;
			float: right;
			width: 150px;
			height: 150px;
		}
		.logo
		{
			max-width: 100%; 
			max-height: 100%;
		}
		.titre
		{
			text-align: center;
			
		}
		h3,h5
		{
			margin-bottom: 0%;
		}
		.fantom
		{
			border: none;
			min-width: 250px;
		}
		.grisG
		{
			background-color: rgb(221, 218, 218);
			font-weight: bold;
			text-align: center;
		}
		.grisP
		{
			background-color: rgb(221, 218, 218);
			text-align: center;
		}
		.txtCent{
			text-align: center;
		}
		.tableAvis{
			text-align: center;
			
		}
		.BUT12{
			min-width: 525px;
		}
	</style>
	';
}
?>