<?php

    function enTete1_2() 
	{
        echo "<!DOCTYPE html>\n";
        echo "<html lang='fr'>\n";
		echo "<head>\n";
		echo "<meta charset='UTF-8'>\n";
		echo "<meta name='Author' lang='fr' content='Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA'  />\n";
        echo "<link rel='stylesheet' href='../css/style.css' type='text/css' />\n";

	}

    function enTete2_2() 
	{
        echo "</head>\n";
        echo "<body>\n";
        echo "<br>\n";
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