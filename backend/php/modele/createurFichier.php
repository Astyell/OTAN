<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Inclusion de la bibliothèque PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


function creerPvComm($semestre)
{
    // Création d'une nouvelle instance de classe Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélection de la feuille active
    $sheet = $spreadsheet->getActiveSheet();

    // Insérer des données dans différentes cellules
    $sheet->setCellValue('A1', 'Nom');
    $sheet->setCellValue('B1', 'Prénom');
    $sheet->setCellValue('C1', 'Âge');

    // Données à insérer (exemples)
    $data = [
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
    }
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

