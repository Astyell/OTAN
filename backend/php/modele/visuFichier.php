<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
//__DIR__ .
$chemin_du_fichier = '../DB/DB.inc.php';
// require $chemin_du_fichier;

require ("../../backend/php/DB/DB.inc.php");

$db = DB::getInstance();
$etudiants = $db->getAllEtudiant();
$noteComp  = $db->getAllNoteComp();
$etuSem    = $db->getAllEtuSem();
$competences = $db->getAllCompetence();
$etuRes  = $db->getAllEtuRes();
$etuAnn = $db->getAllEtuAnn();

function afficheEtudiants(){
	global $etudiants;
	if (!empty($etudiants)) {
		foreach ($etudiants as $etudiant) {
			echo "<p>etudiant :" . $etudiant->__toString() . "</p>";
		}
	} else {
		echo "No students found.";
	}
}
function rechercheEtuAnn($ne,$ann) : ?etuAnn
{
	global $etuAnn;
	foreach ($etuAnn as $e) 
	{
		if($e->getN_Etud() == $ne && $e->getId_annee() == $ann ){return $e;}
	}
	return null;
}
function rechercheEtuRess($ne,$ress) : ?etuRes
{
	global $etuRes;
	foreach ($etuRes as $e) 
	{
		if($e->getN_Etud() == $ne && $e->getId_ressource() == $ress ){return $e;}
	}
	return null;
}
function rechercheNoteEtuComp($ne,$comp) : ?noteComp
{
	global $noteComp;
	foreach ($noteComp as $note) 
	{
		if($note->getN_Etud() == $ne && $note->getId_competence() == $comp ){return $note;}
	}
	return null;
}

function rechercheEtu($ne,$pe) : ?etudiant
{
	global $etudiants;
	foreach ($etudiants as $etu) 
	{
		if($etu->getNom_Etu() == $ne && $etu->getPrenom_Etu() == $pe ){return $etu;}
	}
	return null;
}

function rechercheEtuSem($ne,$numSemestre) : ?etuSem
{
	global $etuSem;
	
	foreach ($etuSem as $etuS) 
	{
		if($etuS->getN_Etud() == $ne && $etuS->getId_Semestre() == $numSemestre ){return $etuS;}
	}
	return null;
}



function afficheEntete($numSemestre,$nb) 
{
	global $db;
	switch ($numSemestre) {
		case 2:
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 1 </b> </td>";
			echo "\t\t<td colspan=\"8\"><b> UEs années </b> </td>";
			echo "\t\t<td><b>Annee</b></td>";
			break;
		case 3:
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 1 </b> </td>";
			echo "\t\t<td colspan=\"8\"><b> UEs du S3 </b> </td>";
			break;
		case 4:
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 1 </b> </td>";
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 2 </b> </td>";
			echo "\t\t<td colspan=\"8\"><b> UEs années </b> </td>";
			echo "\t\t<td><b>Annee</b></td>";
			break;
		case 5:
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 1 </b> </td>";
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 2 </b> </td>";
			echo "\t\t<td colspan=\"3\"><b> Compétences BUT 3 </b> </td>";
			echo "\t\t<td colspan=\"5\"><b> UEs du S5 		  </b> </td>";
			break;
		case 6:
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 1 </b> </td>";
			echo "\t\t<td colspan=\"6\"><b> Compétences BUT 2 </b> </td>";
			echo "\t\t<td colspan=\"3\"><b> Compétences BUT 3 </b> </td>";
			echo "\t\t<td colspan=\"5\"><b> UEs du S6 		  </b> </td>";
			break;
		default:
			break;
	}
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function ecrireAnnee($competences,$oCompetences,$etu,$pair)
{
	global $db;
	$i=0;
	
	$numSemestre = $competences[0]->getId_Semestre();
	$nbCompetences=0;

	if ($numSemestre > 3) { $nbCompetences = 3;}
	else {$nbCompetences=6;}

	while($i < $nbCompetences )
	{ 
		
		$noteA = $db->getGradeForEtuAndCompetence($etu->getN_Etud(),  $competences[$i]->getId_competence());
		if ($pair) 
		{ 
			$noteB = $db->getGradeForEtuAndCompetence($etu->getN_Etud(), $oCompetences[$i]->getId_competence());

			if (empty($noteA) || empty($noteB)) 
			{
				echo "<td class=\"rouge\">AJ</td>";
			}
			else 
			{
				if ( ($noteA[0]->getMoy_UE() + $noteB[0]->getMoy_UE())/2 > 10)
				{
					if($noteA[0]->getMoy_UE() < 10 || $noteB[0]->getMoy_UE() <10)
					{
						echo "<td class=\"vert\">CMP</td>";
					}
					else {
						echo "<td class=\"vert\">ADM</td>";
					}
				}
				else 
				{
					echo "<td class=\"rouge\">AJ</td>";
				}
			}		
		}
		else 
		{
			if (empty($noteA))
			{
				echo "<td class=\"rouge\">AJ</td>";
			}
			else 
			{
				if ( ($noteA[0]->getMoy_UE() > 10))
				{				 
					echo "<td class=\"vert\">ADM</td>";
				}
				else 
				{
					echo "<td class=\"rouge\">AJ</td>";
				}
			} 
		}
		$i++;
	}
	
	if ($numSemestre > 4)
	{
		
		while ($i < 3) 
		{
			debug_to_console($i);
			echo "<td class=\"rouge\">NA</td>";
			$i++;	
		}
	}
	else 
	{
		while ($i < 6) 
		{
			debug_to_console($i);
			echo "<td class=\"rouge\">NA</td>";
			$i++;	
		}
	}
}

function afficheAnnee($numSemestre,$pair,$etu)
{
	global $db;
	
	if ($numSemestre == 1) 
	{
		echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
		return;
	}

	if ($numSemestre >= 2)
	{
		//BUT 1
		$competences  = $db->getCompetencesForSemestre(1);
		$oCompetences = $db->getCompetencesForSemestre(2);

		ecrireAnnee($competences,$oCompetences,$etu,$pair);

		if ($numSemestre >= 4)
		{
			//BUT2
			$competences  = $db->getCompetencesForSemestre(3);
			$oCompetences = $db->getCompetencesForSemestre(4);

			ecrireAnnee($competences,$oCompetences,$etu,$pair);

			if($numSemestre > 4 )
			{
				//BUT 3
				$competences  = $db->getCompetencesForSemestre(5);
				$oCompetences = $db->getCompetencesForSemestre(6);

				for ($i=0; $i < count($competences); $i++) 
				{ 
					$noteA = $db->getGradeForEtuAndCompetence($etu->getN_Etud(),  $competences[$i]->getId_competence());
					$noteB = $db->getGradeForEtuAndCompetence($etu->getN_Etud(),  $competences[$i]->getId_competence());

					if ( ($noteA[0]->getMoy_UE() + $noteB[0]->getMoy_UE())/2 > 10)
					{
						if($noteA[0]->getMoy_UE() < 10 || $noteB[0]->getMoy_UE() <10)
						{
							echo "<td class=\"vert\">CMP</td>";
						}
						else {
							echo "<td class=\"vert\">ADM</td>";
						}
					}
					else 
					{
						echo "<td class=\"rouge\">AJ</td>";
					}
				}
			}
		}
	}
}

function afficheCompetences($competences) 
{
	foreach ($competences as $competence) 
	{
        echo "\t\t<td><b>{$competence->getId_competence()}</b></td>"; 
    }
}

function enteteAnnee($numSemestre) 
{
	for ($i=2; $i <= $numSemestre && $i <6; $i+=2) 
	{ 
		echo "\t\t<td><b>C1</b></td>"; 
		echo "\t\t<td><b>C2</b></td>"; 
		echo "\t\t<td><b>C3</b></td>"; 
		echo "\t\t<td><b>C4</b></td>"; 
		echo "\t\t<td><b>C5</b></td>"; 
		echo "\t\t<td><b>C6</b></td>"; 
	}
	
	if ($numSemestre == 1) 
	{
		echo "\t\t<td><b>C1</b></td>"; 
		echo "\t\t<td><b>C2</b></td>"; 
		echo "\t\t<td><b>C3</b></td>"; 
		echo "\t\t<td><b>C4</b></td>"; 
		echo "\t\t<td><b>C5</b></td>"; 
		echo "\t\t<td><b>C6</b></td>";  
	}

	if ($numSemestre >= 5) 
	{
		echo "\t\t<td><b>C1</b></td>"; 
		echo "\t\t<td><b>C2</b></td>";
		echo "\t\t<td><b>C6</b></td>"; 
	}
}

function afficheJury($numSemestre,$annee) 
{
    global $db;
	$pair = ($numSemestre %2 ==0);
   
    $competences = $db->getCompetencesForSemestre($numSemestre);

	//Avoir les competences des deux semestres
	if ($pair) { $oCompetences = $db->getCompetencesForSemestre($numSemestre-1);} // 2-1 = 1 
	else 	   { $oCompetences = $db->getCompetencesForSemestre($numSemestre+1);} // 1+1 = 2

	echo "<div class=\"Titre\">";
	echo "<h2> BUT - ". $annee .					"</h2>";
	echo "<h2> Semestre $numSemestre - BUT INFO		 </h2>";
	echo "<h2> $annee - ".($annee+1).				"</h2>";
	echo "<h2> Jury du DATE 						 </h2>";
	echo "</div>";
    
    echo "<table class=\"tableJury\">";
	echo "";

	if ($numSemestre > 1)
	{
		echo "\t  <tr>\n";
		echo "\t\t<td colspan=\"6\"></td>\n";
		afficheEntete($numSemestre,count($competences));
		echo "\t  </tr>\n";
	}
	
	echo "\t  <tr>\n";
    echo "\t\t<td><b>code NIP</b></td>"; 
    echo "\t\t<td><b>Rg</b></td>"; 
    echo "\t\t<td><b>Nom</b></td>"; 
    echo "\t\t<td><b>Prénom</b></td>"; 
    echo "\t\t<td><b>Parcours</b></td>"; 
    echo "\t\t<td><b>Cursus</b></td>"; 
    
	enteteAnnee($numSemestre);
	afficheCompetences($competences);

    echo "\t\t<td><b>UEs</b></td>"; 
    echo "\t\t<td><b>Moy</b></td>"; 
    echo "\t  </tr>\n";

	//Etudiants et notes
    $vueComm = $db->getVueCommission($numSemestre,$annee);

    foreach ($vueComm as $i => $etudiant) {
        $etu = rechercheEtu($etudiant->getNom(), $etudiant->getPreNom());
        //$etuSem = rechercheEtuSem($etu->getN_Etud(), $numSemestre);

        echo "\t  <tr>\n";
        echo "\t\t<td>".  $etu->getN_Ip() ."</td>\n";
        echo "\t\t<td>". ($i + 1) ."/" .count($vueComm) ."</td>\n";
        echo "\t\t<td>". $etudiant->getNom() ."</td>\n";
        echo "\t\t<td>". $etudiant->getPrenom() ."</td>\n";
        echo "\t\t<td>". rechercheEtuAnn($etu->getN_Etud(),$annee)->getParcours() ."</td>\n";
        echo "\t\t<td>". $etudiant->getCursus() ."</td>\n";

		afficheAnnee($numSemestre,$pair,$etu);

        //BIN
        foreach ($competences as $competence) {
            $grade = $db->getGradeForEtuAndCompetence($etu->getN_Etud(), $competence->getId_competence());
            echo "\t\t<td>". ($grade[0]->getMoy_UE()) ."</td>\n";
        }

        echo "\t\t<td>". $etudiant->getUE() ."</td>\n";
        echo "\t\t<td>". $etudiant->getMoy() ."</td>\n";
		
		if ($pair) 
		{
			if (rechercheEtuAnn($etu->getN_Etud(),$annee)->getAdmission() == null ) 
			{
				//echo "NA";
			}
			echo "\t\t<td>". rechercheEtuAnn($etu->getN_Etud(),$annee)->getAdmission() ."</td>\n";
		}
		
        echo "\t  </tr>\n";
    }
    echo "</table>";
}


function affichePvCommission($numSemestre,$annee) 
{
	global $db;
	
	if ($numSemestre != 1 && $numSemestre !=3 && $numSemestre !=5) 
	{
		echo "<b>Erreur : Il faut choisir le semestre 1,3 ou 5</b>";
		return;
	}	

	echo "<div class=\"Titre\">";
	echo "<h1> Semestre $numSemestre - BUT INFO</h1>";
	echo "<h1> $annee - ".($annee+1)."</h1>";
	echo "<h1> Commission du DATE </h1>";
	echo "</div>";

	/* Premiere ligne, entetes */
	echo "<table class=\"tableVueCommission\">";
	echo "\t  <tr>\n";
	echo "\t\t<td><b>Rang	</b></td>"; 
	echo "\t\t<td><b>Nom	</b></td>"; 
	echo "\t\t<td><b>Prenom </b></td>"; 
	echo "\t\t<td><b>Cursus </b></td>"; 
	echo "\t\t<td><b>UE	    </b></td>"; 
	echo "\t\t<td><b>Moy	</b></td>"; 

	$nomColonne = $db->getVueNomColonne($numSemestre, $annee);


	//On remplit l'entete de toutes les ressources et compétences, elles sont déjà triées
    $comp = null;
    foreach($nomColonne as $nom)
    {					
        if($comp != $nom->getCompetence())
        {
            $comp = $nom->getCompetence();
            echo "\t\t<td><b>$comp	</b></td>"; 
			echo "\t\t<td><b>Bonus	</b></td>"; 
            
        }
        
        echo "\t\t<td><b>".$nom->getRessource()	."</b></td>"; 
        
	}
	echo "\t  </tr>\n";


	echo "\t <tr><td></td><td></td><td></td><td></td><td></td><td></td>";
	
    foreach($nomColonne as $nom)
    {					
 
        echo "\t\t<td><b>".$nom->getCoef()	."</b></td>"; 
        
	}
	echo "\t  </tr>\n";

	$vueComm = $db->getVueCommission($numSemestre,$annee);
	

	for ($i=0; $i < count($vueComm);$i++ ) 
	{
		echo "\t  <tr>\n";				//On remplit le profil de l'étudiant
		echo "\t\t<td>". $i+1   ."/" .count($vueComm)."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getNom()    ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getPrenom() ."</td>\n";
		echo "\t\t<td class=\"Cursus\">". $vueComm[$i] ->getCursus() ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getUE()     ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getMoy()    ."</td>\n";

		$comp = null;
		foreach($nomColonne as $nom)
		{
			if($comp != $nom->getCompetence()) //Chaque fois qu'on trouve une nouvelle compétence
			{
				$comp = $nom->getCompetence();
				$tmpEtu = rechercheEtu($vueComm[$i] ->getNom() ,$vueComm[$i] ->getPrenom()); 
				$ne = $tmpEtu->getN_Etud();
				echo "\t\t<td class=\"note\">". rechercheNoteEtuComp($ne,$comp)->getMoy_UE()	."</td>"; //recherche de la moyenne générale de cette UE à l'aide de n_etud et du nom de la compétence 
				$bonus = rechercheEtuSem($ne,$numSemestre)->getBonus();
				if ($bonus == 0) { $bonus = "";}
				echo "\t\t<td class=\"note\">". $bonus ."</td>"; 
				
			}
			$tmpEtuRess = rechercheEtuRess($ne,$nom->getRessource());   //->getMoy();
			if ($tmpEtuRess == null) { $tmpEtuRess = "";}
			else {$tmpEtuRess = $tmpEtuRess->getMoy();}
			echo "\t\t<td class=\"note\">". $tmpEtuRess	."</b></td>";  // recherche de la moyenne dans cette ressource à l'aide de n_etud et du nom de la ressource
			
		}

		echo "\t  </tr>\n";

	}
	echo "</table>";
}
