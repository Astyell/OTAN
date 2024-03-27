<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure l'autoloader de Composer
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Créer une nouvelle instance de classe Spreadsheet
$spreadsheet = new Spreadsheet();

// Sélectionner la feuille de calcul active
$feuille = $spreadsheet->getActiveSheet();

// Remplir la feuille de calcul avec des données
$feuille->setCellValue('A1', 'Nom');
$feuille->setCellValue('B1', 'Âge');
$feuille->setCellValue('A2', 'John');
$feuille->setCellValue('B2', 30);
$feuille->setCellValue('A3', 'Jane');
$feuille->setCellValue('B3', 25);

// Créer un objet Writer
$writer = new Xlsx($spreadsheet);

// Enregistrer le fichier Excel dans un répertoire
$nom_fichier = 'exemple.xlsx';
$writer->save($nom_fichier);

// Modifier les permissions du fichier (optionnel)
chmod($nom_fichier, 0644); // Modifie les permissions à 0644 (lecture/écriture pour le propriétaire, lecture seule pour les autres)

// Télécharger le fichier Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nom_fichier . '"');
header('Cache-Control: max-age=0');
readfile($nom_fichier); // Envoyer le contenu du fichier directement au navigateur

echo "c bon";
?>
