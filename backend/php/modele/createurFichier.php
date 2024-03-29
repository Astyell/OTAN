<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$chemin = __DIR__;
require ( $chemin . "/../DB/DB.inc.php");

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;


creerPvComm(1,1);

//TODO: mettre coeff et changer date ??
function creerPvComm($semestre, $annee)
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
    $sheet->setCellValue('E3', $annee . ' - ' . ($annee + 1));//a changer ?
    $sheet->setCellValue('E4', 'COMMISION DU <date>');//a changer ?

    //Nom des colonnes
    $sheet->getStyle('A8:CA8')->getFont()->setBold(true);
    $sheet->setCellValue('A8', 'Rg');
    $sheet->setCellValue('B8', 'Nom');
    $sheet->setCellValue('C8', 'Prénom');
    $sheet->setCellValue('D8', 'Cursus');
    $sheet->setCellValue('E8', 'UEs');
    $sheet->setCellValue('F8', 'Moy');

    //Mettre nom competence et ressource
    $nomColonne = $db->getVueNomColonne($semestre, $annee);

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
    $etudiants = $db->getVueCommission($semestre, $annee);
    
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
    $moyRessources = $db->getVueMoyRessource($semestre, $annee);
    $moyCompetences = $db->getVueMoyCompetence($semestre, $annee);
    $bonusEtud = $db->getAllEtuSemWithSem($semestre, $annee);

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
        foreach ($moyCompetences as $moyComp) 
        {
            if( strstr($numEtud, $moyComp->getNetud()) )
            {
                $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

                for ($col = 1; $col <= $lastCol; $col++) 
                {
                    $currentCol = Coordinate::stringFromColumnIndex($col);
                    
                    if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), $moyComp->getCompetence() )
                        && !strstr ($sheet->getCell($currentCol . 8)->getValue(), "Bonus" ) ) 
                    {
                        $moyen = $moyComp->getMoy();
                        $sheet->setCellValue($currentCol . $ligne, $moyComp->getMoy());

                        //ajouter couleur
                        switch (true) 
                        {
                            case ($moyen > 10): $couleur = '00FF00'; break;
                            case ($moyen > 8):  $couleur = 'FFFF00'; break;
                            case ($moyen > 0):  $couleur = 'FF0000'; break;
                            default:            $couleur = 'FFFFFF'; break;
                        }
                        $sheet->getStyle($currentCol . $ligne)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($couleur); 
                    }
                }
            }
        }

        foreach ($bonusEtud as $bonus) 
        {
            if( strstr($numEtud, $bonus->getN_Etud()) )
            {
                $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

                for ($col = 1; $col <= $lastCol; $col++) 
                {
                    $currentCol = Coordinate::stringFromColumnIndex($col);
                    
                    if( $sheet->getCell($currentCol . 8)->getValue() != null && strstr ($sheet->getCell($currentCol . 8)->getValue(), "Bonus" ) ) 
                    {
                        $sheet->setCellValue($currentCol . $ligne, $bonus->getBonus());  
                    }
                }
            }
        }
    }

    $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
   
    // Appliquer les bordures à la plage de cellules
    $sheet->getStyle('A8:'. Coordinate::stringFromColumnIndex($lastCol) . (9 + count($etudiants)))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Ajuster automatiquement la largeur des colonnes en fonction du contenu
    for ($col = 1; $col <= $lastCol; $col++) 
    {
        $currentCol = Coordinate::stringFromColumnIndex($col);
        $sheet->getColumnDimension($currentCol)->setAutoSize(true);
    }

    //telecharger
    telecharger("PV Commission S" . $semestre . ".xlsx", $spreadsheet);//manque mois et année
}


//creerPvJury(5, 1);

function creerPvJury($semestre, $annee)
{
    // Création d'une nouvelle instance de classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélection de la feuille active
    $sheet = $spreadsheet->getActiveSheet();

    //recup de la base de donnée
    $db = DB::getInstance();

    //Titre feuille
    $sheet->getStyle('F2:F5')->getFont()->setBold(true);
    $sheet->getStyle('F2:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('F2:F5')->getFont()->setSize(18);

    $sheet->setCellValue('F2', "BUT " . ($semestre/2) . " INFORMATIQUE");
    $sheet->setCellValue('F3', 'Semestre ' . $semestre);//a changer ?
    $sheet->setCellValue('F4', '2023 - 2024');//a changer ?
    $sheet->setCellValue('F5', 'JURY DU <date>');//a changer ?

    //Nom des colonnes
    $sheet->getStyle('A7:CA8')->getFont()->setBold(true);
    $sheet->setCellValue('A8', 'code_nip');
    $sheet->setCellValue('B8', 'Rg');
    $sheet->setCellValue('C8', 'Nom');
    $sheet->setCellValue('D8', 'Prénom');
    $sheet->setCellValue('E8', 'Parcours');
    //$sheet->setCellValue('F8', 'Cursus');

    //ajout info étudiant
    $etudiants = $db->getVueCommission($semestre, $annee);

    $ligne = 9;
    foreach($etudiants as $etud)
    {
        $numSemestre = 'S' . $semestre;
        if( strstr ( $etud->getCursus(), $numSemestre ) )
        {
            $lastPosition = strrpos($etud->getCursus(), $numSemestre);
            if ($lastPosition !== false) {
                $cursus = substr($etud->getCursus(), 0, $lastPosition + strlen($numSemestre));
            }

            $sheet->setCellValue('A' . $ligne, $etud->getNip());
            $sheet->setCellValue('B' . $ligne, ($ligne - 8) . "/" . count($etudiants));
            $sheet->setCellValue('C' . $ligne, $etud->getNom());
            $sheet->setCellValue('D' . $ligne, $etud->getPrenom());
            $sheet->setCellValue('E' . $ligne, 'A'); //TODO: tkt parcours = A
            $sheet->setCellValue('F' . $ligne, $cursus);

            $ligne++;
        } 
    }






    $lastCol = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
   
    // Appliquer les bordures à la plage de cellules
    $sheet->getStyle('A8:'. Coordinate::stringFromColumnIndex($lastCol) . (9 + count($etudiants)))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Ajuster automatiquement la largeur des colonnes en fonction du contenu
    for ($col = 1; $col <= $lastCol; $col++) 
    {
        $currentCol = Coordinate::stringFromColumnIndex($col);
        $sheet->getColumnDimension($currentCol)->setAutoSize(true);
    }


    telecharger("PV Jury S" . $semestre . ".xlsx", $spreadsheet);
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

