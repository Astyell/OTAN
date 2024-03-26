<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../vendor/autoload.php';
require 'DB/DB.inc.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Chemin vers le fichier Excel
$chemin_fichier = 'S1 FI moyennes.xlsx';
$spreadsheet = IOFactory::load($chemin_fichier);

// Sélectionner la première feuille de calcul
$feuille = $spreadsheet->getActiveSheet();

// Récupérer les données de la feuille de calcul
$data = [];
foreach ($feuille->getRowIterator() as $row) 
{
    $rowData = [];
    foreach ($row->getCellIterator() as $cell) 
	{
        $rowData[] = $cell->getValue();
    }
    $data[] = $rowData;
}

$db = DB::getInstance();

//TODO: A changer
//$db->insertIdentifiant('root', 'toor', true);
//$db->insertIdentifiant('toto', 'zuzu', false);

//annee
$annee = 1;
$db->insertAnnee($annee);

//création compétences et ressources
$semestre = '';
for($j = 0; $j < count($data[0]); $j++)
{
	if(strstr($data[0][$j], "BIN"))
	{
		if( strlen($data[0][$j]) == 5)
		{
			if($semestre == '')
			{
				$semestre = substr($data[0][$j], 3, 1);
				$db->insertSemestre($semestre, $annee);
				echo "semestre " . $semestre . "<br>";
			}
			
			$id_comp = $data[0][$j];
			$db->insertCompetence($id_comp);
			echo "competaence " . $id_comp . "<br>";
		}
		if( strlen($data[0][$j]) == 7)
		{
			$id_res = $data[0][$j];
			
			$db->insertRessource($id_res, $semestre);

			//Pas de coef
			$db->insertResCom($id_res, $id_comp, 0);//coef = 0

			echo "ressource " . $id_res . "<br>";
		}
	}
}

for($i = 1; $i < count($data); $i++)
{
	$bonus = 0.00;
	$parcours = '';
	$admission = '';

	echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa" . $i;

	for($j = 0; $j < count($data[$i]); $j++)
	{
		if(strstr($data[0][$j], "Bonus"))
		{
			$bonus = $data[$i][$j];
		}

		switch($data[0][$j])
		{
			case 'etudid'   : $n_etud = $data[$i][$j]; break;
			case 'code_nip' : $nip    = $data[$i][$j]; break; 
			case 'Nom'      : $nom    = $data[$i][$j]; break; 
			case 'Prénom'   : $prenom = $data[$i][$j]; break; 
			case 'Cursus'   : $cursus = $data[$i][$j]; break; 
			case 'Bac'      : $bac    = $data[$i][$j]; break;

			case 'TP' : $tp = $data[$i][$j]; break;
			case 'TD' : $td = $data[$i][$j]; break;
			case 'UEs' : $nb_UE = $data[$i][$j]; break;
			case 'Moy' : $moy_gene = $data[$i][$j]; break;
			case 'Abs' : $nbAbsInjust = $data[$i][$j]; break;
			case 'Just.' : $nbAbsJust = $data[$i][$j]; break;

			case 'Parcours' : $parcours = $data[$i][$j]; break;
			case 'Année' : $admission = $data[$i][$j]; break;
		}
		echo $data[0][$j] . ' : '. $data[$i][$j] . '<br>';
	}

	$db->insertEtudiant($n_etud, $nip, $nom, $prenom, $cursus, $bac);
	$db->insertEtuSem($n_etud, $semestre, $tp, $td, $nbAbsInjust, $nbAbsJust, $moy_gene, $nb_UE);
	$db->insertEtuAnn($n_etud, $annee, $bonus, $parcours, $admission);
}

for($i = 1; $i < count($data); $i++)
{
	for($j = 0; $j < count($data[$i]); $j++)
	{
		if($data[0][$j] == 'etudid')
		{
			$n_etud = $data[$i][$j]; 
		}
		
		if(strstr($data[0][$j], "BIN"))
		{
			if( strlen($data[0][$j]) == 5)
			{
				$id_comp = $data[0][$j];
				$moy_UE = $data[$i][$j];

				$db->insertNoteComp($n_etud, $id_comp, $moy_UE);
			}
			if( strlen($data[0][$j]) == 7)
			{
				$id_res = $data[0][$j];
				$moy_res = $data[$i][$j];

				$db->insertEtuRes($n_etud, $id_res, $moy_res);
			}
		}
	}
}


?>

