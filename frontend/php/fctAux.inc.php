<?php
	function enTeteVisuali() 
	{
        echo "<!DOCTYPE html>\n";
        echo "<html lang='fr'>\n";
		echo "<head>\n";
		echo "<meta charset='UTF-8'>\n";
		echo "<meta name='Author' lang='fr' content='Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA'  />\n";
        echo "<link rel='stylesheet' href='../css/style.css' type='text/css' />\n";
		echo "<title>Menu</title>\n";
		echo "</head>\n";
        echo "<body>\n";
        echo "<br>\n";
	}

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

    function headerMenuVisuali()
    {
        echo "<header class=\"headerVisu\">\n";
        echo "<div class=\"menuBar\">\n";
        echo "<a href=\"importation.html\" class=\"imp\"> <img src=\"../img/logo_telecharger.png\" title=\"importation\" alt=\"importationLogo\"></a>\n";
        echo "<a href=\"exportation.html\" class=\"Exp\"> <img class=\"imaInvers\" src=\"../img/logo_telecharger.png\" title=\"exportation\" alt=\"exportationLogo\"></a>\n";
        echo "<a href=\"templateAvisPoursuiteEtud.html\" class=\"../img/avis\"> <img src=\"logo_avi.png\" title=\"template Avis Poursuite Etude\" alt=\"poursuiteEtudLogo\"></a>\n";
        echo "<a href=\"connexion.html\" class=\"quiter\"> <img src=\"../img/logo_deconnexion.png\" title=\"déconnexion\" alt=\"quitterLogo\"></a>\n";
        echo "</div>\n";
        echo "<hr class=\"ligne\">\n";
        echo "</header>\n";
    }

    function navMenuVisuali()//TODO : retacher une fonction celonn le bouton cliquer pour changer l'affichage
    {
        /* Ce menu est composé d'un tableau séparé en 6 parti chacune de ses parties représente un semestre.
		Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission.*/
        echo '<!-- Ce menu est composé d\'un tableau séparé en 6 parti chacune de ses parties représente un semestre. -->' + "\n";
		echo '<!-- Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission. -->' + "\n";
		echo "<nav class=\"menuVue\" >\n";
        echo "<table  >\n";
		echo "<tbody>\n<tr>\n";
		echo "<TD ROWSPAN=2>S1</TD> \n";
		echo "<td ><button class=\"BcommJur\">Commission</button></td>\n";
		echo "</tr> \n<tr>\n";
		echo "<td ><button class=\"BcommJur\">Jury</button></td>\n";
		echo "</tr> \n<tr> \n<td>S2</td>\n";
		echo "<td ><button class=\"BJurPair\">Jury</button></td>\n";
		echo "</tr> \n<tr> \n<TD ROWSPAN=2>S3</TD> \n";
		echo "<td ><button class=\"BcommJur\">Commission</button></td>\n";
		echo "</tr> \n<tr>\n";
		echo "<td ><button class=\"BcommJur\">Jury</button></td>\n";
		echo "</tr> \n<tr> \n<td>S4</td>\n";
		echo "<td ><button class=\"BJurPair\">Jury</button></td>\n";
		echo "</tr> \n<tr>\n <TD ROWSPAN=2>S5</TD> \n";
		echo "<td ><button class=\"BcommJur\">Commission</button></td>\n";
		echo "</tr>\n <tr>\n";
		echo "<td ><button class=\"BcommJur\">Jury</button></td>\n";
		echo "</tr>\n <tr>\n <td>S6</td>\n";
		echo "<td ><button class=\"BJurPair\" >Jury</button></td>\n";
		echo "</tr>\n</tbody>\n";
        echo "</table > \n";
        echo "</nav>\n";
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