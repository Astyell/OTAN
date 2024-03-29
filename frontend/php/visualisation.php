<?php
	/** connexion.php
	* @author  : Alizéa Lebaron, Justine BONDU
	* @since   : 26/03/2024
	* @version : 1.0.2 - 29/03/2024
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
	<title>Menu</title>
</head>

<body>

	<header>
		<nav class="navbar">
			<ul>
				<li><a href="visualisation.php" class="accueil"><img src="../img/icone/OTAN.png"   alt="import" class="icon"> </a></li>
				<li><img src="../img/icone/import.png" alt="import">         <a href="choixFichier.php">Importer</a></li>
				<li><img src="../img/icone/export.png" alt="export">         <a href="#">Exporter</a></li>
				<li><img src="../img/icone/doc.png"    alt="poursuite etude"><a href="#">Fiche poursuite d'étude</a></li>
				<li><img src="../img/icone/power.png"  alt="deconnexion">    <a href="deconnexion.php">Déconnexion</a></li>
			</ul>
		</nav>
    </header>
	
	<!-- Ce menu est composé d\'un tableau séparé en 6 parti chacune de ses parties représente un semestre. -->
	<!-- Chaque semestre comporte un bouton jury, et les semestres impairs ont, en plus un bouton commission. -->
	<nav class="menuVue" >
		<table>
			<tr>
				<td rowspan=2>S1</td> 
				<td><button class="BcommJur">Commission</button></td>
			</tr> 
			
			<tr>
				<td ><button class="BcommJur">Jury</button></td>
			</tr> 
			
			<tr> 
				<td>S2</td>
				<td ><button class="BJurPair">Jury</button></td>
			</tr> 
			
			<tr> 
				<td ROWSPAN=2>S3</td> 
				<td ><button class="BcommJur">Commission</button></td>
			</tr>

			<tr>
				<td ><button class="BcommJur">Jury</button></td>
			</tr> 
			
			<tr> 
				<td>S4</td>
				<td ><button class="BJurPair">Jury</button></td>
			</tr> 
			
			<tr> 
				<td ROWSPAN=2>S5</td> 
				<td ><button class="BcommJur">Commission</button></td>
			</tr> 
			
			<tr>
				<td ><button class="BcommJur">Jury</button></td>
			</tr> 

			<tr> 
				<td>S6</td>
				<td ><button class="BJurPair" >Jury</button></td>
			</tr>
		</table> 
    </nav> 

</body>
</html>

	

