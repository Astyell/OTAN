<?php
	function enTeteMenu() 
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
		echo "<header>\n";
        echo "<h1>Menu</h1>\n";
        echo "</header>\n";
        echo "<br>\n";
        echo "<br>\n";
	}

    function headerMenu()
    {
        //TODO : remplacer "provisoir_imm" par les vrai images
        echo "<header >";
        echo "<div class=\"menuBar\">";
        echo "<a href=\"importation.html\" class=\"imp\"> <img src=\"../img/provisoir_imm.png\" title=\"importation\" alt=\"importationLogo\"></a>";
        echo "<a href=\"exportation.html\" class=\"Exp\"> <img src=\"../img/provisoir_imm.png\" title=\"exportation\" alt=\"exportationLogo\"></a>";
        echo "<a href=\"templateAvisPoursuiteEtud.html\" class=\"../img/avis\"> <img src=\"logo_avi.png\" title=\"template Avis Poursuite Etude\" alt=\"poursuiteEtudLogo\"></a>";
        echo "<a href=\"connexion.html\" class=\"quiter\"> <img src=\"../img/provisoir_imm.png\" title=\"déconnexion\" alt=\"quitterLogo\"></a>";
        echo "</div>";
        echo "<hr class=\"ligne\">";
        echo "</header>";
    }

    function navMenu()
    {
        //TODO : changer les a href pour appeler une fonctione quoi change les donnné de la page pour correspondre au semestre selectionner
        echo "<nav class=\"menuVue\" >";
        echo "<table  >";
        echo "<tr > <th > <a href=\"menuS1.php\" class=\"menuVueA\"> S1 </a>  </th > </tr > ";
        echo "<tr > <th > <a href=\"menuS2.php\" class=\"menuVueA\"> S2 </a> </th > </tr > ";
        echo "<tr > <th > <a href=\"menuS3.php\" class=\"menuVueA\"> S3 </a> </th > </tr > ";
        echo "<tr > <th > <a href=\"menuS4.php\" class=\"menuVueA\"> S4 </a> </th > </tr > ";
        echo "<tr > <th > <a href=\"menuS5.php\" class=\"menuVueA\"> S5 </a> </th > </tr > ";
        echo "<tr > <th > <a href=\"menuS6.php\" class=\"menuVueA\"> S6 </a> </th > </tr > ";
        echo "</table > ";
        echo "</nav>";
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