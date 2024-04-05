<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
require 'modele/ficheAvis.php';

use Dompdf\Dompdf;

$argument1 = $_COOKIE['annee2'];
$argument2 = $_COOKIE['netud'];

if($argument1 != null && $argument2 != null && !strstr($argument2, 'null'))
{
    genererAvis($argument1, $argument2);
}

function genererAvis($annee, $netud)
{
	//Recuperation images
	$imageData1 = base64_encode(file_get_contents( __DIR__ . '/../../frontend/img/download/logo1.png'));
	$imageData2 = base64_encode(file_get_contents( __DIR__ . '/../../frontend/img/download/logo2.png'));
	$imageData3 = base64_encode(file_get_contents( __DIR__ . '/../../frontend/img/download/signChefDep.png'));

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

	$html = getTop();

	$db = DB::getInstance();

	$etudiants = $db->getAllEtuSemWithSem(5, $annee);

	foreach($etudiants as $etudiant)
	{
		$html .= ficheAvis($annee, $etudiant->getN_Etud(), $imageData1, $imageData2, $imageData3);
		$html .= "<br><br><br><br><br><br>";
	}
	$html .= getBot();

	$dompdf->loadHtml($html);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream('Avis-' . $netud . '-' . $annee);
}

