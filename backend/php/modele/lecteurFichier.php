<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin = (__DIR__ . "/../DB/DB.inc.php");
require $chemin;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function mettreDansDB($chemin_fichier, $annee1)
{
	// Chemin vers le fichier Excel
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

	//TODO: annee
	$annee = $annee1;
	$db->insertAnnee($annee);

	//création compétences et ressources
	$altern = 0;
	$semestre = null;

	for($j = 0; $j < count($data[0]); $j++)
	{
		if( $data[0][$j] != null && strstr($data[0][$j], "BIN"))
		{
			if( strstr($data[0][$j], "A"))//enleve les A pour les alternants
			{
				$data[0][$j] = rtrim($data[0][$j], "A");
				$altern = 1;
			}
			
			//création compétence
			if( strlen($data[0][$j]) == 5 )//Ex : BIN12 ou BIN12A pour alternant
			{
				//création semestre si existe pas
				if($semestre == null)
				{
					$semestre = substr($data[0][$j], 3, 1);
					$db->insertSemestre($semestre, $annee);
					//echo "semestre " . $semestre . "  ". $annee. "<br>";
				}
				
				$id_comp = $data[0][$j];
				$db->insertCompetence($id_comp, $semestre, $annee);
				//echo "competaence " . $id_comp . "<br>";
			}
			//création ressources
			if( strlen($data[0][$j]) == 7 )//Ex BINR121 ou BINR121A pour alternant
			{
				$id_res = $data[0][$j];
				
				$db->insertRessource($id_res, $semestre, $annee);

				//Pas de coef
				$db->insertResCom($id_res, $id_comp, 0);//coef = 0

				//echo "ressource " . $id_res . "<br>";
			}
		}
	}

	//déclaration de variables
	$n_etud = null;
	$nip = null;
	$nom = null;
	$prenom = null;
	$bac = null;
	$tp = null;
	$td = null;
	$nbAbsInjust = null;
	$nbAbsJust = null;
	$moy_gene = null;
	$nb_UE = null;

	for($i = 1; $i < count($data); $i++)
	{
		//création variable qui se reset
		$bonus = 0.00;
		$parcours = '';
		$admission = '';
		$cursus = '';

		for($j = 0; $j < count($data[$i]); $j++)
		{
			//verification de bonus
			if( $data[0][$j] != null && strstr($data[0][$j], "Bonus"))
			{
				$bonus = $data[$i][$j];
			}

			//mettre dans variables
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
			//echo $data[0][$j] . ' : '. $data[$i][$j] . '<br>';
		}

		//création etudiants
		$db->insertEtudiant($n_etud, $nip, $nom, $prenom, $cursus, $bac);
		$db->insertEtuSem($n_etud, $semestre, $annee, $tp, $td, $nbAbsInjust, $nbAbsJust, $moy_gene, $nb_UE, $altern);
		$db->insertEtuAnn($n_etud, $annee, $parcours, $admission);

		if($admission != null)
		{
			$db->updateEtuAnn($n_etud, $annee, $admission);
		}

		//TODO: voir si les trucs avec  bonus sont doublés
		if($bonus != null)
		{
			$db->updateEtuSem($n_etud, $semestre, $bonus);
		}
	}

	//repassable sur le doc pour avoir les etudiant, ressources et compétences deja créer
	for($i = 1; $i < count($data); $i++)
	{
		for($j = 0; $j < count($data[$i]); $j++)
		{
			//recup n_etud
			if($data[0][$j] == 'etudid')
			{
				$n_etud = $data[$i][$j]; 
			}
			
			if($data[0][$j] != null && strstr($data[0][$j], "BIN"))
			{
				//création note comp
				if( strlen($data[0][$j]) == 5 )
				{
					$id_comp = $data[0][$j];
					$moy_UE = $data[$i][$j];

					$db->insertNoteComp($n_etud, $id_comp, $moy_UE);
				}
				//création etu res
				if( strlen($data[0][$j]) == 7 )
				{
					$id_res = $data[0][$j];
					$moy_res = $data[$i][$j];

					$db->insertEtuRes($n_etud, $id_res, $moy_res);
				}
			}
		}
	}
	echo " ajoutés dans la base de données !";
}


function mettreCoef($chemin_fichier)
{
	try 
	{
		// Chemin vers le fichier Excel
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

		for($i = 0; $i < count($data); $i++)
		{
			if($data[$i][0] != null)
			{
				$semestre = substr($data[$i][0], 4, 1);
				
				for($j = 0; $j < 6; $j++)
				{
					if($data[$i][3 + $j] != null)
					{
						//echo $data[$i][0] .   '   BIN' . $semestre . $j+1 . "  ". $data[$i][3 + $j] . "<br>";
						$db->updateResCom($data[$i][0], 'BIN' . $semestre . ($j+1), $data[$i][3 + $j]);
					}
				}
			}
		}

		echo " mis dans la base de donnée";
	} catch (\Throwable $th) {
		echo " n'est pas un fichier avec des valeurs compatibles";
	}
}

?>

