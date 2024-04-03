<?php
	/** choixFichier.php
	* @author  : Justine BONDU, Matéo SA, Alizéa LEBARON
	* @since   : 27/03/2024
	* @version : 2.1.0 - 03/04/2024
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

	enTete1_2();
	echo "<link rel='stylesheet' href='../css/header.css'  type='text/css' />\n";
	echo "<link rel='stylesheet' href='../css/impoExp.css' type='text/css'/>\n";
	echo "<link rel='stylesheet' href='../css/footer.css'  type='text/css' />\n";
	echo "<title>O.T.A.N. - Exporter</title>\n";
	enTete2_2();
	incHeaderAdmin();
	$db = DB::getInstance();
	$lstAnn = $db->getAllAnnee();
	echo "<h1>Exporter</h1>\n";
	echo "<section class=\"encad\">\n";
	corps($lstAnn);
	echo "</section>\n";
	pied();
	echo "</body>\n</html>\n";


	function corps($lstAnn)
	{
		echo "<form method=\"post\">\n";
		echo "<label for=\"choix_fichier\">Choisir le type de fichier :</label>\n";
		echo "<select name=\"choix_fichier\" id=\"choix_fichier\">\n";
		echo "<option value=\"jury/moyenne\" selected>Fichier Jury/Moyenne</option>\n";
		echo "<option value=\"fichier coef\">Fichier Coef</option>\n";
		echo "</select>\n";
		echo "<input type=\"submit\" name=\"submit\" value=\"Sélectionner\">\n";
		echo "</form>\n";

		// Vérifier si le formulaire est soumis
		if(isset($_POST['submit'])){
			// Vérifier si une option est sélectionnée
			if(isset($_POST['choix_fichier'])){
				$choix = $_POST['choix_fichier'];
				// Appeler la fonction appropriée en fonction de l'option sélectionnée
				if($choix == "jury/moyenne"){
					selectionFichier($lstAnn);
				} elseif($choix == "fichier coef"){
					selectionFichier2();
				}
			}
		}
	}

	function selectionFichier($lstAnn)
	{
		echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
		echo "<label for=\"file\">Sélectionner un fichier :</label>\n";
		echo "<input type=\"file\" id=\"file\" name=\"file\" accept=\".xlsx\" required><br><br>\n";
		echo "<label for=\"annee\">Entrez l'année du fichier :</label>\n";
		echo "<select name=\"annee\" onchange=\"afficherOuCacherChamp()\">\n";
		foreach ($lstAnn as $annee) {
			echo "<option value='".$annee->getId_annee()."'>".$annee->getId_annee()."</option>\n";
		}

		echo "<option value=\"NouvelleAnnee\">Nouvelle Annee</option>\n";
		echo "</select><br><br>\n";
		echo "<p id=\"nouvelleAnneeText\" style=\"display:none;\">Nouvelle année:</p>\n";
		echo "<input type=\"text\" id=\"nombre\" name=\"nombre\" pattern=\"[0-9]+\" style=\"display:none;\"required><br>\n";

		echo "<p> Attention tout enregistrement est définitif, pour modifier les données, il faudra le faire directement sur la page visualisation ou supprimer les données puis re-télécharger les données. </p>\n<br><br>\n";
		echo "<input type=\"submit\" name=\"submit\" class=\"Valid\" value=\"Enregistrer\">\n";
		echo "</form>";

		if(isset($_POST['submit']) && isset($_FILES['file'])) 
		{
			$chemin_fichier = $_FILES['file']['tmp_name'];
			$annee_selectionnee = $_POST['annee'];
			if ($annee_selectionnee == 'NouvelleAnnee') {
				$annee_selectionnee = $_POST['nombre'];
			}
			mettreDansDB($chemin_fichier, $annee_selectionnee);
		}
	}

	function selectionFichier2()
	{
		echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
		echo "<label for=\"file\">Sélectionner un fichier :</label>\n";
		echo "<input type=\"file\" id=\"file\" name=\"file\" accept=\".xlsx\" required><br><br>\n";
		echo "<p> Attention tout enregistrement est définitif, pour modifier les données, il faudra le faire directement sur la page visualisation ou supprimer les données puis re-télécharger les données. </p><br><br>\n";
		echo "<input type=\"submit\" name=\"submit\" class=\"Valid\" value=\"Enregistrer\">\n";
		echo "</form>\n";
		// Vérifier si le formulaire a été soumis et si un fichier a été envoyé
		if( isset($_POST['submit']) && isset($_FILES['file']) ) 
		{
			// Récupérer le nom du fichier
			$file_name = $_FILES['file']['name'];

			// Appeler la méthode mettreDansDB() avec le chemin du fichier envoyé
			$chemin_fichier = $_FILES['file']['tmp_name'];

			//mettreDansDB($chemin_fichier);
		}
	}
?>
<script type="text/javascript">
	function afficherOuCacherChamp() {
		var selectElement = document.getElementsByName('annee')[0];
		var optionSelected = selectElement.options[selectElement.selectedIndex].value;
		var nouvelleAnneeText = document.getElementById('nouvelleAnneeText');
		var nombreInput = document.getElementById('nombre');

		if (optionSelected == 'NouvelleAnnee') {
			nouvelleAnneeText.style.display = 'block';
			nombreInput.style.display = 'block';
		} else {
			nouvelleAnneeText.style.display = 'none';
			nombreInput.style.display = 'none';
		}
	}
</script>

