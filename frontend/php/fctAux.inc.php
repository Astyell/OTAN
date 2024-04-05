<?php

/** fctAux.inc.php
	* @author  : Alizéa Lebaron, Justine BONDU
	* @since   : 26/03/2024
	* @version : 1.1.4 - 03/04/2024
	*/

function incHeaderAdmin ()
{
    $sRet = '<header>' .
    '<nav class="navbar">' .
        '<ul>' .
            '<li><a href="visualisation.php" class="accueil"><img src="../img/icone/OTAN.png"   alt="import" class="icon"> </a></li>' .
            '<li><img src="../img/icone/import.png" alt="import">         <a href="choixFichier.php">Importer</a></li>' . 
            '<li><img src="../img/icone/export.png" alt="export">         <a href="exporter.php">Exporter</a></li>' .
            '<li><img src="../img/icone/user.png" alt="user">         <a href="utilisateur.php">Utilisateurs</a></li>' .
            '<li class="center"><img src="../img/icone/doc.png"    alt="poursuite etude"><a href="avis.php">Fiche poursuite d\'étude</a></li>' .
            '<li><img src="../img/icone/power.png"  alt="deconnexion">    <a href="deconnexion.php">Déconnexion</a></li>' .
        '</ul>' .
    '</nav>' .
    '</header>';
    echo $sRet;
}

function incHeaderUser ()
{
	$sRet = '<header>' .
	'<nav class="navbar">' .
		'<ul>' .
			'<li><a href="visualisation.php" class="accueil"><img src="../img/icone/OTAN.png"   alt="import" class="icon"> </a></li>' .
			'<li><img src="../img/icone/export.png" alt="export">         <a href="exporter.php">Exporter</a></li>' .
			'<li class="center"><img src="../img/icone/doc.png"    alt="poursuite etude" ><a href="avis.php">Fiche poursuite d\'étude</a></li>' .
			'<li><img src="../img/icone/power.png"  alt="deconnexion">    <a href="deconnexion.php">Déconnexion</a></li>' .
		'</ul>' .
	'</nav>' .
	'</header>';
	echo $sRet;
}

// Utilisée dans Avis.php
function incUpAvis ()
{
	$sAv = '<div id="modifier">'.
		'<h2 class="modifTitre">Modification de la fiche</h2>' .
		'<form action="avis.php" method="post" enctype="multipart/form-data">' .
			'<label for="logo1">Choisir le logo 1 :</label>' .
			'<input type="file" id="logo1" name="logo1" accept="image/*">' .
			'<label for="logo2">Choisir le logo 2 :</label>' .
			'<input type="file" id="logo2" name="logo2" accept="image/*">' .
			'<label for="anneeProm">Année de la promo :</label>' .
			'<input type="text" id="anneeProm" name="anneeProm" accept="image/*">' .
			'<label for="nomChef">Nom du chef du département :</label>' .
			'<input type="text" id="nomChef" name="nomChef" accept="image/*">' .
			'<label for="signChefDep">Choisir la signature du chef du département :</label>' .
			'<input type="file" id="signChefDep" name="signChefDep" accept="image/*">' .
			'<input type="submit" value="Envoyer">' .
		'</form>' .
	'</div>';

	echo $sAv;
}

// Utilisée dans Avis.php
function downloadImage ($nom)
{
	// On renseigne le dossier dans lequel elles sont téléchargées
	$repertoireImages = '../img/download/';

	$cheminFichier = $repertoireImages . $nom . ".png";

	// On crée l'image 
	move_uploaded_file($_FILES[$nom]['tmp_name'], $cheminFichier);
}

	function enTete1_2() 
	{
		echo "<!DOCTYPE html>\n";
		echo "<html lang='fr'>\n";
		echo "\t<head>\n";
		echo "\t \t<meta charset='UTF-8'>\n";
		echo "\t \t<meta name='Author' lang='fr' content='Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA'  />\n";
	}

	function enTete2_2() 
	{
		echo "\t</head>\n";
		echo "\t<body>\n";
	}

	function verifMDP($mdp) 
	{ 
		define('PREFIXE_SHA1', 'O&5Li_rZ*/78'); //Afin de sécuriser le mot de passe on ajoute un constant devant qui sera aussi haché
		$mdp_sha1 = sha1(PREFIXE_SHA1.$mdp); //Cryptage du mdp

		return $mdp_sha1;
	}

	function pied() 
	{
		$footer = '<footer>'.
		'<a href="https://github.com/Astyell/OTAN"><img src="../img/icone/Github.svg" alt="github" id="git" class="github-icon"></a>'.
		'<div class="row">'.
			'<ul>'.
				'<li><a class="lienGit" href="https://github.com/MatKim76">Matéo SA</a></li>'.
				'<li><a class="lienGit" href="https://github.com/Sebeaty">Sébastien CHAMPVILLARD</a></li>'.
				'<li><a class="lienGit" href="https://github.com/Astyell">Alizéa LEBARON</a></li>'.
				'<li><a class="lienGit" href="https://github.com/Julia123456789037">Justine BONDU</a></li>'.
			'</ul>'.
		'</div>'.
		'<p> 2024 - O.T.A.N. - All rights reserved</p>'.
		'</footer>';
		echo $footer;
	}
?>