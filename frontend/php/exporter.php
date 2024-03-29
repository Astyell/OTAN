<?php
	include ("fctAux.inc.php");
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

    // Vérification que la session existe bien
    if (!isset($_SESSION['id'])) 
    {
        header('Location: connexion.php');
        exit();
    }

    // Récupération des données
    $ID    = $_SESSION [   'id'];
    $droit = $_SESSION ['droit'];

    if ($droit != 1) 
    {
        header('Location: visualisation.php');
        exit();
    }
	enTete1_2();
    echo "<link rel='stylesheet' href='../css/header.css' type='text/css' />\n";
    echo "<link rel='stylesheet' href='../css/impoExp.css' type='text/css' />\n";
	echo "<title>Importer</title>";
	enTete2_2();
    // Afficher le header en fonction de l'utilisateur
    incHeaderAdmin();

	echo "<p class=\"titreP\"> Exporter </p>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<section class=\"encad\">\n";
	corps();
	echo "</section>\n";
	echo "<br>\n";
	pied();

	function corps()
	{



	}


?>