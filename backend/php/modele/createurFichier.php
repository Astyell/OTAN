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

creerPvComm(6);

function creerPvComm($semestre)
{
    // Création d'une nouvelle instance de classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélection de la feuille active
    $sheet = $spreadsheet->getActiveSheet();

    //Titre feuille
    $sheet->getStyle('E2:E4')->getFont()->setBold(true);
    $sheet->getStyle('E2:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E2:E4')->getFont()->setSize(18);

    $sheet->setCellValue('E2', 'Semestre ' . $semestre . " - BUT INFO");
    $sheet->setCellValue('E3', '2023 - 2024');//a changer ?
    $sheet->setCellValue('E4', 'COMMISION DU 1er Février 2024');//a changer ?

    //Nom des colonnes
    $sheet->getStyle('A8:CA8')->getFont()->setBold(true);


    $db = DB::getInstance();
    $etudiants = $db->getVueCommission($semestre);
    
    
    $ligne = 10;
    foreach($etudiants as $etud)
    {
        $colonne = 'B';
        for($compteur = 0; $compteur < 5; $compteur++)
        {
            $sheet->setCellValue($colonne . $ligne, $etud->getInfo($compteur) );
            $colonne++;
        }
        $ligne++;
    }


    // Données à insérer (exemples)
    /*$data = [
        ['Dupont', 'Jean', 30],
        ['Durand', 'Marie', 25],
        ['Martin', 'Pierre', 35],
    ];

    // Insérer les données dans les cellules suivantes
    $row = 2; // Commencer à la ligne 2 après les titres
    foreach ($data as $rowData) {
        $col = 'A';
        foreach ($rowData as $cellData) {
            $sheet->setCellValue($col . $row, $cellData);
            $col++;
        }
        $row++;
    }*/



    /*$highestColumn = $sheet->getHighestColumn();

    // Ajuster automatiquement la largeur des colonnes en fonction du contenu
    foreach (range('A', $highestColumn) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }*/

    telecharger("PV Commission S" . $semestre . ".xlsx", $spreadsheet);//manque mois et année
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

