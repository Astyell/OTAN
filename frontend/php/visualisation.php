
<?php
	include ("fctAux.inc.php");
	require ("DB.inc.php");
    session_start();

	enTeteVisuali();
    headerMenuVisuali();
    navMenuVisuali();
	echo "<br>";
	echo "<br>";


    echo "<br>";
    echo "<section class=\"corp\">";
    corps();
    echo "</section>";

	
	echo "<br>";
	pied();

    function corps() 
	{
        echo "<section class=\"copr\">";
		$db = DB::getInstance();

        
	}
?>
