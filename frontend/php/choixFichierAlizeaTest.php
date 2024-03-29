<?php
	include ("fctAux.inc.php");
	require '../../Controleur.php';
    session_start();

	enTete1_2();
	echo "<title>Sélectionner un fichier</title>";
	enTete2_2();
	echo "<header >\n";
	echo "<p> Importer </p>";
	echo "</header>\n";
	echo "<br>";
	error_reporting(E_ALL);
	ini_set('display_errors', 1);


    echo "<br>";
    echo "<section class=\"encad\">";
    corps();
    echo "</section>";

	
    function corps() 
	{
		selectionFichier();

		// Vérifier si le formulaire a été soumis et si un fichier a été envoyé
		if(isset($_POST['submit']) && isset($_FILES['file'])) 
		{
			// Récupérer le nom du fichier
			$file_name = $_FILES['file']['name'];

			// Appeler la méthode mettreDansDB() avec le chemin du fichier envoyé
			$chemin_fichier = $_FILES['file']['tmp_name'];
			mettreDansDBControleur($chemin_fichier);
		}
	}


	function selectionFichier()
	{
		echo '<form action="" method="post" enctype="multipart/form-data">
			<label for="file">Sélectionner un fichier :</label><br>
			<input type="file" id="file" name="file" accept=".xlsx"><br><br>
			<input type="submit" name="submit" value="envListe">
		</form>';
}
?>

