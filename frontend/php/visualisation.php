<?php
	/** connexion.php
	* @author  : Alizéa Lebaron, Justine BONDU
	* @since   : 26/03/2024
	* @version : 1.0.3 - 29/03/2024
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
	<title>Menu</title>
</head>

<body>

	<?php
		// Afficher le header
		incHeader();
	?>
	
	<!-- Ce menu est composé d\'un tableau séparé en 6 parti chacune de ses parties représente un semestre. -->
	<!-- Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission. -->
	
	<div class = "select" >

		<label>Veuillez choisir un ou plusieurs animaux :</label>
			<select name="fichier">
				<optgroup label="Année 1">
				<option value="1_S1_Moyenne">S1 - Moyenne</option>
				<option value="1_S1_Jury"   >S1 - Jury   </option>
				<option value="1_S2_Moyenne">S2 - Moyenne</option>
				<option value="1_S2_Jury"   >S2 - Jury   </option>
				</optgroup>
				<optgroup label="Année 2">
				<option value="2_S3_Moyenne">S3 - Moyenne</option>
				<option value="2_S3_Jury"   >S3 - Jury   </option>
				<option value="2_S4_Moyenne">S4 - Moyenne</option>
				<option value="2_S4_Jury"   >S4 - Jury   </option>
				</optgroup>
				<optgroup label="Année 3">
				<option value="3_S5_Moyenne">S5 - Moyenne</option>
				<option value="3_S5_Jury"   >S5 - Jury   </option>
				<option value="3_S6_Moyenne">S6 - Moyenne</option>
				<option value="3_S6_Jury"   >S6 - Jury   </option>
				</optgroup>
			</select>
		
		


	</div>

</body>
</html>

	

