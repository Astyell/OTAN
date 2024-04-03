<?php
	/** choixFichier.php
	* @author  : Justine BONDU, Matéo SA, Alizéa LEBARON
	* @since   : 27/03/2024
	* @version : 2.0.0 - 03/04/2024
	*/

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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel='stylesheet' href='../css/header.css'  type='text/css' />
	<link rel='stylesheet' href='../css/impoExp.css' type='text/css'/>
	<link rel='stylesheet' href='../css/footer.css'  type='text/css' />

	<title>O.T.A.N. - Importer</title>
</head>
<body>
	
	<?php
		// Afficher le header admin (dans importer seul l'admin peut venir)
		incHeaderAdmin();
	?>

	<h1>Importer</h1>

	<section class="encad">

		<?php
			// Afficher le corps du document
			corps();
		?>

	</section>

	<?php
		// Afficher le footer
		pied();
	?>

</body>
</html>

<?php
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
            <p> Attention tout enregistrement est définitif, pour modifier les données, il faudra le faire directement sur la page visualisation ou supprimer les données puis re-télécharger les données. </p><br><br>
			<input type="submit" name="submit" class="Valid" value="Enregistrer">
		</form>';
	}

?>