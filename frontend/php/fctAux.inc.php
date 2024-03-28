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
		echo "<header>\n";
        echo "<h1>Menu</h1>\n";
        echo "</header>\n";
        echo "<br>\n";
        echo "<br>\n";
	}

    function headerMenuVisuali()
    {
        echo "<header >";
        echo "<div class=\"menuBar\">";
        echo "<a href=\"importation.html\" class=\"imp\"> <img src=\"../img/logo_telecharger.png\" title=\"importation\" alt=\"importationLogo\"></a>";
        echo "<a href=\"exportation.html\" class=\"Exp\"> <img class=\"imaInvers\" src=\"../img/logo_telecharger.png\" title=\"exportation\" alt=\"exportationLogo\"></a>";
        echo "<a href=\"templateAvisPoursuiteEtud.html\" class=\"../img/avis\"> <img src=\"logo_avi.png\" title=\"template Avis Poursuite Etude\" alt=\"poursuiteEtudLogo\"></a>";
        echo "<a href=\"connexion.html\" class=\"quiter\"> <img src=\"../img/logo_deconnexion.png\" title=\"déconnexion\" alt=\"quitterLogo\"></a>";
        echo "</div>";
        echo "<hr class=\"ligne\">";
        echo "</header>";
    }

    function navMenuVisuali()//TODO : retacher une fonction celonn le bouton cliquer pour changer l'affichage
    {
        /* Ce menu est composé d'un tableau séparé en 6 parti chacune de ses parties représente un semestre.
		Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission.*/
        echo '<!-- Ce menu est composé d\'un tableau séparé en 6 parti chacune de ses parties représente un semestre. -->';
		echo '<!-- Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission. -->';
		echo "<nav class=\"menuVue\" >";
        echo "<table  >";
		echo "<tbody><tr>";
		echo "<TD ROWSPAN=2>S1</TD> ";
		echo "<td ><button class=\"BcommJur\">Commission</button></td>";
		echo "</tr> <tr>";
		echo "<td ><button class=\"BcommJur\">Jury</button></td>";
		echo "</tr> <tr> <td>S2</td>";
		echo "<td ><button class=\"BJurPair\">Jury</button></td>";
		echo "</tr> <tr> <TD ROWSPAN=2>S3</TD> ";
		echo "<td ><button class=\"BcommJur\">Commission</button></td>";
		echo "</tr> <tr>";
		echo "<td ><button class=\"BcommJur\">Jury</button></td>";
		echo "</tr> <tr> <td>S4</td>";
		echo "<td ><button class=\"BJurPair\">Jury</button></td>";
		echo "</tr> <tr> <TD ROWSPAN=2>S5</TD> ";
		echo "<td ><button class=\"BcommJur\">Commission</button></td>";
		echo "</tr> <tr>";
		echo "<td ><button class=\"BcommJur\">Jury</button></td>";
		echo "</tr> <tr> <td>S6</td>";
		echo "<td ><button class=\"BJurPair\" >Jury</button></td>";
		echo "</tr></tbody>";
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