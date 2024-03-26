<?php
	function enTeteMenu() 
	{
        echo "<!DOCTYPE html>\n";
        echo "<html lang='fr'>\n";

		echo "<head>\n";
		echo "<meta charset='UTF-8'>\n";
		echo "<meta name='Author' lang='fr' content='Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA'  />\n";
        echo "<link rel='stylesheet' href='style.css' type='text/css' />\n";
		echo "<title>Menu</title>\n";
		echo "</head>\n";
        echo "<body>\n";
		echo "<header>\n";
        echo "<h1>Menu</h1>\n";
        echo "</header>\n";
        echo "<br>\n";
        echo "<br>\n";
	}

    function headerMenu()
    {
        echo "<header >";
        echo "<div class=\"menuBar\">";
        echo "<a href=\"importation.html\" class=\"imp\"> <img src=\"provisoir_imm.png\" title=\"importation\" alt=\"importationLogo\"></a>";
        echo "<a href=\"exportation.html\" class=\"Exp\"> <img src=\"provisoir_imm.png\" title=\"exportation\" alt=\"exportationLogo\"></a>";
        echo "<a href=\"templateAvisPoursuiteEtud.html\" class=\"avis\"> <img src=\"provisoir_imm.png\" title=\"template Avis Poursuite Etude\" alt=\"poursuiteEtudLogo\"></a>";
        echo "<a href=\"connexion.html\" class=\"quiter\"> <img src=\"provisoir_imm.png\" title=\"déconnexion\" alt=\"quitterLogo\"></a>";
        echo "</div>";
        echo "<div id=\"ligne\"></div>";
        echo "</header>";
    }

    function asideMenu()
    {
        echo "<header >";
        echo "<div class=\"menuBar\">";
        echo "<a href=\"importation.html\" class=\"imp\"> <img src=\"provisoir_imm.png\" title=\"importation\" alt=\"importationLogo\"></a>";
        echo "<a href=\"exportation.html\" class=\"Exp\"> <img src=\"provisoir_imm.png\" title=\"exportation\" alt=\"exportationLogo\"></a>";
        echo "<a href=\"templateAvisPoursuiteEtud.html\" class=\"avis\"> <img src=\"provisoir_imm.png\" title=\"template Avis Poursuite Etude\" alt=\"poursuiteEtudLogo\"></a>";
        echo "<a href=\"connexion.html\" class=\"quiter\"> <img src=\"provisoir_imm.png\" title=\"déconnexion\" alt=\"quitterLogo\"></a>";
        echo "</div>";
        echo "<div id=\"ligne\"></div>";
        echo "</header>";
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
?>