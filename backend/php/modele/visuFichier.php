<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin_du_fichier = __DIR__ . "./../DB/DB.inc.php";
require $chemin_du_fichier;



$db = DB::getInstance();
$etudiants = $db->getAllEtudiant();
$noteComp = $db->getAllNoteComp();
$etuSem = $db->getAllEtuSem();



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

function rechercheNoteEtu($ne,$comp) : noteComp
{
	global $noteComp;
	foreach ($noteComp as $note) 
	{
		if($note->getN_Etud() == $ne && $note->getId_competence() == $comp ){return $note;}
		
	}
	return null;
}

function rechercheEtu($ne,$pe) : etudiant
{
	global $etudiants;
	
	foreach ($etudiants as $etu) 
	{
		if($etu->getNom_Etu() == $ne && $etu->getPrenom_Etu() == $pe ){return $etu;}
	}
	return null;
}

function rechercheEtuSem($ne,$numSemestre) : etuSem
{
	global $etuSem;
	
	foreach ($etuSem as $etuS) 
	{
		if($etuS->getN_Etud() == $ne && $etuS->getId_Semestre() == $numSemestre ){return $etuS;}
	}
	return null;
}


function affichePvCommission($numSemestre) 
{
	global $db;
	
	if ($numSemestre != 1 || $numSemestre !=3 || $numSemestre !=5) 
	{
		echo "<b>Erreur : Il faut choisir le semestre 1,3 ou 5</b>";
		return;
	}	

	/* Premiere ligne, entetes */
	echo "<table class=\"tableVueCommission\">";
	echo "\t  <tr>\n";
	echo "\t\t<td><b>Rang	</b></td>"; 
	echo "\t\t<td><b>Nom	</b></td>"; 
	echo "\t\t<td><b>Prenom </b></td>"; 
	echo "\t\t<td><b>Cursus </b></td>"; 
	echo "\t\t<td><b>UE	    </b></td>"; 
	echo "\t\t<td><b>Moy	</b></td>"; 
	echo "\t  </tr>\n";

	$vueComm= $db-> getVueCommission($numSemestre);

	for ($i=0; $i < count($vueComm);$i++ ) 
	{
		echo "\t  <tr>\n";
		echo "\t\t<td>". $i+1   ."/" .count($vueComm)."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getNom()    ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getPrenom() ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getCursus() ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getUE()     ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getMoy()    ."</td>\n";
		echo "\t  </tr>\n";

	}
	echo "</table>";
}

function afficheEntete($divi) 
{

	echo "\t\t<td><b>C1</b></td>\n";
	echo "\t\t<td><b>C2</b></td>\n";
	echo "\t\t<td><b>C3</b></td>\n";
	echo "\t\t<td><b>C4</b></td>\n";
	echo "\t\t<td><b>C5</b></td>\n";
	echo "\t\t<td><b>C6</b></td>\n";
}

function afficheBUT($etuS)  
{
	$numSemestre = $etuS->getId_Semestre();
	echo "\t\t<td>". $etuS->getNbUe() . "/".$numSemestre."</td>\n";
	echo "\t\t<td>". $etuS->getMoyGeneral()."</td>\n";
	echo "\t\t<td>". $etuS ."</td>\n";
	echo "\t\t<td>". $etuS ."</td>\n";
	echo "\t\t<td>". $etuS ."</td>\n";
	echo "\t\t<td>". $etuS ."</td>\n";
	echo "\t\t<td>". $etuS ."</td>\n";
	echo "\t\t<td>". $etuS ."</td>\n";
}

function afficheUE($reste)
{
	echo "\t\t<td><b>UE   </b></td>\n";
	echo "\t\t<td><b>Moys </b></td>\n";
	echo "\t\t<td><b>BIN11</b></td>\n";
	echo "\t\t<td><b>BIN12</b></td>\n";
	echo "\t\t<td><b>BIN13</b></td>\n";
	echo "\t\t<td><b>BIN14</b></td>\n";
	echo "\t\t<td><b>BIN15</b></td>\n";
	echo "\t\t<td><b>BIN16</b></td>\n";
}

function afficheJury($numSemestre) 
{
	global $db;
	$div = intdiv($numSemestre,2);
	$res = $numSemestre % 2 ;

	/* Premiere ligne, entetes */
	echo "<link rel=\"stylesheet\" href=\"../../../frontend/css/visuTest.css\">";
	echo "<table class=\"tableJury\">";
	echo "\t  <tr>\n";
	echo "\t\t<td><b>code NIP</b></td>"; 
	echo "\t\t<td><b>Rang	 </b></td>"; 
	echo "\t\t<td><b>Nom	 </b></td>"; 
	echo "\t\t<td><b>Prenom  </b></td>"; 
	echo "\t\t<td><b>Parcours</b></td>"; 
	echo "\t\t<td><b>Cursus	     </b></td>"; 
	afficheEntete($div);
	afficheUE($res);
	echo "\t  </tr>\n";
	

	$vueComm= $db-> getVueCommission($numSemestre);

	for ($i=0; $i < count($vueComm);$i++ ) 
	{
		$etu = rechercheEtu($vueComm[$i]->getNom(),$vueComm[$i]->getPreNom());
		echo "\t  <tr>\n";
		echo "\t\t<td>".  $etu->getN_Ip()    ."</td>\n";
		echo "\t\t<td>". $i+1   ."/" .count($vueComm)                  ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getNom()    ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getPrenom() ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getCursus() ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getUE()     ."</td>\n";
		echo "\t\t<td>". $vueComm[$i] ->getMoy()    ."</td>\n";
		afficheBUT(rechercheEtuSem($etu->getN_Etud(),$numSemestre));
	}
	echo "</table>";
}

afficheJury(1);