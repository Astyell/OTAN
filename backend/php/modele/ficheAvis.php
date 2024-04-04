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

function ficheAvis($annee, $nEtud)
{
	$db = DB::getInstance();

	$noteComp = $db->getAllNoteCompOrder($annee);

	//$etudiant = $db->getEtudiantEtud($nEtud)[0];


	$moyUe = array();
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
						echo "1";
					}			
					
					if ($note->getId_competence() == $competences[$cpt]->getId_competence()) //Si c'est la bonne compétence
					{
						$resS2[$nbS2++] = $note->getMoy_UE();
						echo "2";
					}		
				}	
			}
		}

		$nbEtu = -1;
	}




	for($i=0;$i<count($moyUe);$i++)
	{
		echo $moyUe[$i][0] . "  ";
		for($j=1;$j<count($moyUe[$i]);$j++)
		{
			//$moyUe[$i][$j] = $moyUe[$i][$j];
			
			echo $moyUe[$i][$j] . "  ";
		}
		echo '<br>';
	}
	
	

	
	echo '
	<!DOCTYPE html>
		<html lang="fr">
		
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>O.T.A.N. - Avis de Poursuite d\'Études</title>
		</head>
		
			<body>
			
			<div class="A4">
			<div class="logos">
				<img src="data:image/jpeg;base64,' . $imagePath1 . '" alt="logo 1" class="left_logo" id="logoG" >
				<img src="data:image/jpeg;base64,' . $imagePath2 . '" alt="logo 2" class="right_logo" id="logoD" >
				</div> 

			<br><br><br>
			<div class="titre">
				<h4>Fiche Avis Poursuite d\'Études - Promotion <b id="annee"></b> <br>
					Département Informatique IUT Le Havre</h4>
			</div>


			<h5>FICHE D\'INFORMATION ÉTUDIANT(E)</h5>
			<hr>

			<table class="tabletop">
				<tbody>
					<tr class="Nom-Prenom">
						<td class="refTD"> Nom-Prénom</td>
						<td class="GrefTD" colspan="6">  </td>
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

						<td class="tdPetit"> ' . $info[0][1] .' </td>
						<td class="tdPetit"> ' . $info[0][2] . '/' . $info[0][3] .' </td>
						<td class="tdPetit">' . $info[6][1] .'</td>
						<td class="tdPetit">' . $info[6][2] . '/' . $info[6][3] .'</td>
					</tr>
					<tr>
						<td>UE2 - Optimiser des applications</td>

						<td>' . $info[1][1] .'</td>
						<td>' . $info[1][2] . '/' . $info[1][3] .'</td>
						<td>' . $info[7][1] .'</td>
						<td>' . $info[7][2] . '/' . $info[7][3] .'</td>
					</tr>
					<tr>
						<td>UE3 - Administrer des systèmes</td>

						<td>' . $info[2][1] .'</td>
						<td>' . $info[2][2] . '/' . $info[2][3] .'</td>
						<td>' . $info[8][1] .'</td>
						<td>' . $info[8][2] . '/' . $info[8][3] .'</td>
					</tr>
					<tr>
						<td>UE4 - Gérer des données</td>

						<td>' . $info[3][1] .'</td>
						<td>' . $info[3][2] . '/' . $info[3][3] .'</td>
						<td>' . $info[9][1] .'</td>
						<td>' . $info[9][2] . '/' . $info[9][3] .'</td>
					</tr>
					<tr>
						<td>UE5 - Conduire des projets</td>

						<td>' . $info[4][1] .'</td>
						<td>' . $info[4][2] . '/' . $info[4][3] .'</td>
						<td>' . $info[10][1] .'</td>
						<td>' . $info[10][2] . '/' . $info[10][3] .'</td>
					</tr>
					<tr>
						<td>UE6 - Collaborer</td>

						<td>' . $info[5][1] .'</td>
						<td>' . $info[5][2] . '/' . $info[5][3] .'</td>
						<td>' . $info[11][1] .'</td>
						<td>' . $info[11][2] . '/' . $info[11][3] .'</td>
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

						<td class="tdGrand">' . $info[12][1] .'</td> 
						<td class="tdGrand">' . $info[12][2] . '/' . $info[12][3] .'</td>
						
					</tr>
					<tr>
						<td>UE2 - Optimiser des applications</td>

						<td>' . $info[12][1] .'</td>
						<td>' . $info[12][2] . '/' . $info[12][3] .'</td>
						
					</tr>
					<tr>
						<td>UE3 - Administrer des systèmes</td>

						<td>' . $info[12][1] .'</td>
						<td>' . $info[12][2] . '/' . $info[12][3] .'</td>
						
					</tr>
					<tr>
						<td>UE4 - Gérer des données</td>

						<td>' . $info[12][1] .'</td>
						<td>' . $info[12][2] . '/' . $info[12][3] .'</td>
						
					</tr>
					<tr>
						<td>UE5 - Conduire des projets</td>

						<td>' . $info[12][1] .'</td>
						<td>' . $info[12][2] . '/' . $info[12][3] .'</td>
						
					</tr>
					<tr>
						<td>UE6 - Collaborer</td>

						<td>' . $info[12][1] .'</td>
						<td>' . $info[12][2] . '/' . $info[12][3] .'</td>
						
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
		</body>

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


ficheAvis(2024, '8860');
?>