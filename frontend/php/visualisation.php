<?php
	/** visualisation.php
	* @author  : Alizéa Lebaron, Justine BONDU
	* @since   : 26/03/2024
	* @version : 1.0.4 - 29/03/2024
	*/

	// Affichage des erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Importation
	include ("fctAux.inc.php");
	require ("../../backend/php/DB/DB.inc.php");

	// Début de la session
    session_start();

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
        header('Location: connexion.php');
        exit();
    }

	// Récupération des données
	$ID    = $_SESSION [   'id'];
	$droit = $_SESSION ['droit'];
?>

<!DOCTYPE html>
<html lang='fr'>

<head>
	<meta charset='UTF-8'>
	<meta name='Author' lang='fr' content='Justine BONDU Sébastien CHAMPVILLARD Alizéa LEBARON Matéo SA'/>
	<link rel='stylesheet' href='../css/visualisation.css' type='text/css' />
	<link rel='stylesheet' href='../css/header.css' type='text/css' />
	<link rel='stylesheet' href='../css/footer.css' type='text/css' />
	<title>Menu</title>
</head>

<body>

	<?php
		// Afficher le header en fonction de l'utilisateur
		if ($droit) { incHeaderAdmin(); }
		else        { incHeaderUser (); }
		
	?>
	
	<!-- Ce menu est composé d\'un tableau séparé en 6 parti chacune de ses parties représente un semestre. -->
	<!-- Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission. -->
	
	<div class = "select" >

		<form action="visualisation.php" method="get">

			<label>Fichier à visualiser :</label>
			<select name="fichier">
				<optgroup label="Année 1">
				<option value="1_S1_Comission">S1 - Comission</option>
				<option value="1_S1_Jury"     >S1 - Jury     </option>
				<option value="1_S2_Jury"     >S2 - Jury     </option>
				</optgroup>
				<optgroup label="Année 2">
				<option value="2_S3_Comission">S3 - Comission</option>
				<option value="2_S3_Jury"     >S3 - Jury     </option>
				<option value="2_S4_Jury"     >S4 - Jury     </option>
				</optgroup>
				<optgroup label="Année 3">
				<option value="3_S5_Comission">S5 - Comission</option>
				<option value="3_S5_Jury"     >S5 - Jury     </option>
				</optgroup>
			</select>

			<input type="submit" value="Consulter">

		</form>

	</div>

	<?php

		pied();

	?>

</body>
</html>

	

