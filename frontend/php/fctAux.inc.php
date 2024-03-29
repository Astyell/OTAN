<?php

    function incHeader ()
    {
        $sRet = '<header>' .
		'<nav class="navbar">' .
			'<ul>' .
				'<li><a href="visualisation.php" class="accueil"><img src="../img/icone/OTAN.png"   alt="import" class="icon"> </a></li>' .
				'<li><img src="../img/icone/import.png" alt="import">         <a href="choixFichier.php">Importer</a></li>' . 
				'<li><img src="../img/icone/export.png" alt="export">         <a href="#">Exporter</a></li>' .
				'<li><img src="../img/icone/doc.png"    alt="poursuite etude"><a href="#">Fiche poursuite d\'étude</a></li>' .
				'<li><img src="../img/icone/power.png"  alt="deconnexion">    <a href="deconnexion.php">Déconnexion</a></li>' .
			'</ul>' .
		'</nav>' .
        '</header>';

        echo $sRet;
    }

    function enTete1_2() 
	{
        echo "<!DOCTYPE html>\n";
        echo "<html lang='fr'>\n";
		echo "<head>\n";
		echo "<meta charset='UTF-8'>\n";
		echo "<meta name='Author' lang='fr' content='Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA'  />\n";
        //echo "<link rel='stylesheet' href='../css/style.css' type='text/css' />\n";

	}

    function enTete2_2() 
	{
        echo "</head>\n";
        echo "<body>\n";
	}


    function deuxBoutons($gauche,$droite)  
    {
        echo "<table>\n";
        echo "<td><button class=\"gauche\">$gauche</button></td>\n";
        echo "<td><button class=\"droite\">$droite</button></td>\n";
        echo "</table>\n";
    }



    function pied() 
	{
        echo "<br>\n";
        echo "<br>\n";
        echo "<footer>\n";
		echo "<hr><p>© 2024 par Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA</p>\n";
        echo "</footer>\n";
        echo "<br>\n";
        echo "</body>\n";
        echo "</html>\n";
	}

	function verifMDP($mdp) 
    { 
        define('PREFIXE_SHA1', 'O&5Li_rZ*/78'); //Afin de sécuriser le mot de passe on ajoute un constant devant qui sera aussi haché
        $mdp_sha1 = sha1(PREFIXE_SHA1.$mdp); //Cryptage du mdp

        return $mdp_sha1;
    }


?>