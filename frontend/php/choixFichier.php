<?php
	include ("fctAux.inc.php");
    require '../../backend/php/modele/lecteurFichier.php';
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

    // Vérification que la session existe bien
    if (!isset($_SESSION['id'])) 
    {
        header('Location: connexion.php');
        exit();
    }

    // Récupération des données
    $ID    = $_SESSION [   'id'];
    $droit = $_SESSION ['droit'];

    if ($droit != 1) 
    {
        header('Location: visualisation.php');
        exit();
    }

	enTete1_2();
    echo "<link rel='stylesheet' href='../css/header.css' type='text/css' />\n";
    echo "<link rel='stylesheet' href='../css/impoExp.css' type='text/css' />\n";
    echo "<link rel='stylesheet' href='../css/footer.css' type='text/css' />\n";
	echo "<title>O.T.A.N. - Importer</title>";
	enTete2_2();
    // Afficher le header en fonction de l'utilisateur
    incHeaderAdmin();

	echo "<p class=\"titreP\"> Importer </p>\n";
	echo "<br>\n";
	echo "<br>\n";
	echo "<section class=\"encad\">\n";
	corps();
	echo "</section>\n";
	echo "<br>\n";
	pied();

	function corps()
	{
		selectionFichier();

		// Vérifier si le formulaire a été soumis et si un fichier a été envoyé
		if(isset($_POST['submit']) && isset($_FILES['file']) && isset($_POST['nombre'])) 
		{
			// Récupérer le nom du fichier
			$file_name = $_FILES['file']['name'];

			// Appeler la méthode mettreDansDB() avec le chemin du fichier envoyé
			$chemin_fichier = $_FILES['file']['tmp_name'];

			mettreDansDB($chemin_fichier, $_POST['nombre']);
            echo "<br>\n";
            echo $file_name;
            echo " année ";
            echo $_POST['nombre'];
		}

        echo "</body>\n";
        echo "</html>\n";
	}


	function selectionFichier()
	{
		echo '<form action="" method="post" enctype="multipart/form-data">
			<label for="file">Sélectionner un fichier :</label>
			<input type="file" id="file" name="file" accept=".xlsx" required><br><br>
            <label for="nombre">Entrez l\'année du fichier :</label>
            <input type="text" id="nombre" name="nombre" pattern="[0-9]+" required><br><br><br>
            <label for="submit"> Attention tout enregistrement est définitif, pour modifier les données, il faudra le faire directement sur la page visualisation ou supprimer les données puis re-télécharger les données. </label><br><br>
			<input type="submit" name="submit" class="Valid" value="Enregistrer">
		</form>';
	}

?>