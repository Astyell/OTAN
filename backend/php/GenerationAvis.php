<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
require 'modele/ficheAvis.php';

use Dompdf\Dompdf;

function genererAvis($annee, $netud)
{
	//Recuperation images
	$imageData1 = base64_encode(file_get_contents( __DIR__ . '/../../frontend/img/download/logo1.png'));
	$imageData2 = base64_encode(file_get_contents( __DIR__ . '/../../frontend/img/download/logo2.png'));
	$imageData3 = base64_encode(file_get_contents( __DIR__ . '/../../frontend/img/download/signChefDep.png'));

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->loadHtml(ficheAvis($annee, $netud, $imageData1, $imageData2, $imageData3) );

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream();
}
/*
function AvisAllEtudiant($annee)
{
	$db = DB::getInstance();

	$etudiants = $db->getAllEtuSemWithSem(5, $annee);

	foreach($etudiants as $etudiant)
	{
		genererAvis($annee, $etudiant->getN_Etud());
	}
}
*/
//AvisAllEtudiant(2024);
