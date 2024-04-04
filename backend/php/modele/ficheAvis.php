<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin = (__DIR__ . "/../DB/DB.inc.php");
require $chemin;


ficheAvis(2024, '8860');


function ficheAvis($annee, $nEtud)
{
	$db = DB::getInstance();

	$noteComp = $db->getAllNoteCompOrder($annee);

	$etudiant = $db->getEtudiantEtud($nEtud)[0];

	$info = array(array());
	
	
	$comp = 'hello';
	$nbComp = 0;
	$i = null;
	foreach ($noteComp as $note) 
	{
		if( !strstr($comp, $note->getId_competence()) )
		{
			if($i != null)
			{
				$info[$nbComp][3] = $i;//total gens
				$nbComp++;
			}

			$comp = $note->getId_competence();
			$info[$nbComp][0] = $comp;//nom comp

			$i=1;
			
		}
		
		if( strstr($nEtud, $note->getN_Etud() ))
		{
			$info[$nbComp][1] = $note->getMoy_UE();//moy
			$info[$nbComp][2] = $i;//rank
		}
		$i++;
	}//maque dernier tt gens




	$moyUe = array(array());
	$numEtud = 'hello';
	$nbEtu = -1;

	for($s=1; $s<7; $s++)
	{
		$vueMoyComp = $db->getVueMoyCompetence($s, $annee);
		
		foreach($vueMoyComp as $etud)
		{
			if( !strstr($numEtud, $etud->getNetud()) )
			{
				$nbEtu++;
				$numEtud = $etud->getNetud();
				
				if( empty($moyUe[$nbEtu][0]))
				{
					$moyUe[$nbEtu][0] = $numEtud;
					for($i=1; $i<19; $i++)
					{
						$moyUe[$nbEtu][$i] = 0;
					}
				}
			}

			for($e=0; $e<count($moyUe); $e++)
			{
				if(!empty($moyUe[$e][0]) && strstr($moyUe[$e][0], $etud->getNetud()))
				{
					//echo  $moyUe[$e][0]. "  ". $etud->getNetud() . "   <br> ";
					
					switch (substr($etud->getCompetence(), 4, 1) ) 
					{
						case '1' : $moyUe[$nbEtu][1 + (ceil($s/2)-1) * 6] += $etud->getMoy(); break;
						case '2' : $moyUe[$nbEtu][2 + (ceil($s/2)-1) * 6] += $etud->getMoy(); break;
						case '3' : $moyUe[$nbEtu][3 + (ceil($s/2)-1) * 6] += $etud->getMoy(); break;
						case '4' : $moyUe[$nbEtu][4 + (ceil($s/2)-1) * 6] += $etud->getMoy(); break;
						case '5' : $moyUe[$nbEtu][5 + (ceil($s/2)-1) * 6] += $etud->getMoy(); break;
						case '6' : $moyUe[$nbEtu][6 + (ceil($s/2)-1) * 6] += $etud->getMoy(); break;
						
						//default: $moyUe[$nbEtu][1] = 0; break;
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
			<link rel="stylesheet" href="../../../frontend/css/avis.css">
			<title>O.T.A.N. - Avis de Poursuite d\'Études</title>
		</head>
		
			<body>
			
			<div class="A4">
			<div class="logos">
				<h6 class="left_logo" id="logoG" > Logo 1</h6>
				<h6 class="right_logo" id="logoD" > Logo 2</h6>
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
			<h6 class="signature" id="signDept" > Signature et cachet                     </h6>
			
			</div>
		</body>

	</html>';
}


?>
		