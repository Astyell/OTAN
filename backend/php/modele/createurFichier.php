<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin = __DIR__;
require ( $chemin . "/../DB/DB.inc.php");
//require ( $chemin . "/../DB/vueCommission.inc.php" );

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;


creerPvComm(5);

function creerPvComm($semestre)
{
    // Création d'une nouvelle instance de classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélection de la feuille active
    $sheet = $spreadsheet->getActiveSheet();

    //recup de la base de donnée
    $db = DB::getInstance();

    //Titre feuille
    $sheet->getStyle('E2:E4')->getFont()->setBold(true);
    $sheet->getStyle('E2:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E2:E4')->getFont()->setSize(18);

    $sheet->setCellValue('E2', 'Semestre ' . $semestre . " - BUT INFO");
    $sheet->setCellValue('E3', '2023 - 2024');//a changer ?
    $sheet->setCellValue('E4', 'COMMISION DU 1er Février 2024');//a changer ?

    //Nom des colonnes
    $sheet->getStyle('A8:CA8')->getFont()->setBold(true);
    $sheet->setCellValue('A8', 'Rg');
    $sheet->setCellValue('B8', 'Nom');
    $sheet->setCellValue('C8', 'Prénom');
    $sheet->setCellValue('D8', 'Cursus');
    $sheet->setCellValue('E8', 'UEs');
    $sheet->setCellValue('F8', 'Moy');

    //Mettre nom competence et ressource
    $nomColonne = $db->getVueNomColonne($semestre);

    $ligne = 8;
    $colonne = 'G';

    $comp = null;
    foreach($nomColonne as $nom)
    {
        if($comp != $nom->getCompetence())
        {
            $comp = $nom->getCompetence();
            $sheet->setCellValue($colonne . $ligne, $comp);
            $sheet->setCellValue(++$colonne . $ligne, "Bonus " . $comp);
            $colonne++;
        }
        
        $sheet->setCellValue($colonne . $ligne, $nom->getRessource());
        
        //echo $comp . "  " .$nom->getRessource() . "<br>";
        $colonne++;
    }
    
    //Mettre info étudiants
    $etudiants = $db->getVueCommission($semestre);
    
    $ligne = 10;
    foreach($etudiants as $etud)
    {
        $colonne = 'B';
        for($compteur = 0; $compteur < 5; $compteur++)
        {
            $sheet->setCellValue('A' . $ligne, ($ligne - 9) . "/" . count($etudiants));
            $sheet->setCellValue($colonne . $ligne, $etud->getInfo($compteur) );
            $colonne++;
        }
        $ligne++;
    }

    //Mettre notes ressources
    $moyRessources = $db->getVueMoyRessource($semestre);
    $moyCompetences = $db->getVueMoyCompetence($semestre);

    $numEtud = $moyRessources[0]->getNetud();
    $ligne = 10;
    foreach($moyRessources as $moyRes)
    {
        if ( !strstr($numEtud, $moyRes->getNetud()) ) 
        {
            $ligne++;
        }

        $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

        for ($col = 1; $col <= $lastCol; $col++) 
        {
            $currentCol = Coordinate::stringFromColumnIndex($col);
            
            if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $moyRes->getRessource() ) ) 
            {
                $sheet->setCellValue($currentCol . $ligne, $moyRes->getMoy());  
            }
        }

        $numEtud = $moyRes->getNetud();

        //mettre les note et bonus de competences
        
        //c pas opti mais tkt
        //TODO:voir probleme car bonus mal mis
        foreach ($moyCompetences as $moyComp) 
        {
            if( strstr($numEtud, $moyComp->getNetud()) )
            {
                $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

                for ($col = 1; $col <= $lastCol; $col++) 
                {
                    $currentCol = Coordinate::stringFromColumnIndex($col);
                    $currentCol2 = Coordinate::stringFromColumnIndex($col + 1);
                    
                    if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $moyComp->getCompetence() )
                        && !strstr ($sheet->getCell($currentCol . 8)->getValue(), "Bonus" ) ) 
                    {
                        echo $sheet->getCell($currentCol . 8)->getValue() ."<br>";
                        echo $moyComp->getMoy() . "   " . $moyComp->getBonus() . "<br>";
                        
                        $sheet->setCellValue($currentCol . $ligne, $moyComp->getMoy());  
                        $sheet->setCellValue($currentCol2 . $ligne, $moyComp->getBonus());  
                    }
                }
            }
        }
    }

    



    // Ajuster automatiquement la largeur des colonnes en fonction du contenu
    $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
    for ($col = 1; $col <= $lastCol; $col++) 
    {
        $currentCol = Coordinate::stringFromColumnIndex($col);
        $sheet->getColumnDimension($currentCol)->setAutoSize(true);
    }



    //telecharger("PV Commission S" . $semestre . ".xlsx", $spreadsheet);//manque mois et année
}

function telecharger($nomfichier, $spreadsheet)
{
    //Téléchargement fichier
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$nomfichier.'"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
}

