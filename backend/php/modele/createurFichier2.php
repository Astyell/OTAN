<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php'; // Inclure l'autoloader de PHPExcel

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function creerFichierExcel($donnees, $chemin)
{
    // Créer un nouvel objet Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Sélectionner la première feuille de calcul
    $feuille = $spreadsheet->getActiveSheet();

	foreach ($donnees as $rowIndex => $row) {
        foreach ($row as $columnIndex => $cellValue) {
            // Convertir l'index de colonne en lettre
            $colonneLettre = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex + 1);
            // Définir la valeur de la cellule
            $feuille->setCellValue($colonneLettre . ($rowIndex + 1), $cellValue);
        }
    }

    // Créer un écrivain pour le format Excel2007
    $writer = new Xlsx($spreadsheet);

    // Sauvegarder le fichier Excel
    $writer->save($chemin);

    // Retourner le chemin du fichier créé
    return $chemin;
}

// Exemple d'utilisation de la fonction
$donnees = array(
    array('Nom', 'Âge', 'Ville'),
    array('John Doe', 30, 'New York'),
    array('Jane Doe', 25, 'Los Angeles'),
    array('Bob Smith', 40, 'Chicago')
);

$chemin_fichier = 'exemple.xlsx'; // Chemin où sauvegarder le fichier Excel

// Appeler la fonction pour créer le fichier Excel
$resultat = creerFichierExcel($donnees, $chemin_fichier);

if ($resultat !== false) {
    echo 'Le fichier Excel a été créé avec succès : ' . $resultat;
} else {
    echo 'Une erreur est survenue lors de la création du fichier Excel.';
}

?>
