<?php

	require 'backend/php/modele/lecteurFichier.php';
    require 'backend/php/modele/createurFichier.php';

	function mettreDansDBControleur($chemin_fichier, $annee)
	{
        mettreDansDB($chemin_fichier, $annee);
	}

    function exportExelComm($semestre, $annee)
	{
        creerPvComm($semestre, $annee);
	}
    function exportExelJury($semestre, $annee)
	{
        creerPvJury($semestre, $annee);
	}
?>
