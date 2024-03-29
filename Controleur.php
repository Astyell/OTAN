<?php

	require 'backend/php/modele/lecteurFichier.php';

	function mettreDansDBControleur($chemin_fichier, $annee)
	{
        mettreDansDB($chemin_fichier, $annee);
	}
?>
