<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin_du_fichier = __DIR__ . "./../DB/DB.inc.php";
require $chemin_du_fichier;



$db = DB::getInstance();
$etudiants = $db->getAllEtudiant();
$etusem= $db-> getAllEtuSem();

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


function affichePvCommission($nbSemestre) 
{
	global $etusem;
	if ($nbSemestre != 1 || $nbSemestre !=3 || $nbSemestre !=5) 
	{
		echo "<b>Erreur : Il faut choisir le semestre 1,3 ou 5</b>";
		return;
	}	

	foreach ($etusem as $etuS => $value) 
	{
		echo "<td>rang</td>\n";
		echo "<td>nom</td>\n";
		echo "<td>prenom</td>\n";
		echo "<td>cursus</td>\n";
		echo "<td>UE</td>\n";
		echo "<td>Moy</td>\n";

	}



}

?>
