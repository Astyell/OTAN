
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
    echo "<section class=\"corpV\">";
    corps();
    echo "</section>";

	
	echo "<br>";
	pied();

    function corps() 
	{
		$db = DB::getInstance();
        echo "chalut, faut me compléter";
        
	}
?>
