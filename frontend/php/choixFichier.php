<?php
	/** choixFichier.php
	* @author  : Justine BONDU, Matéo SA, Alizéa LEBARON
	* @since   : 27/03/2024
	* @version : 2.1.1 - 03/04/2024
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
	echo "\t \t<link rel='stylesheet' href='../css/header.css'  type='text/css' />\n";
	echo "\t \t<link rel='stylesheet' href='../css/impoExp.css' type='text/css'/>\n";
	echo "\t \t<link rel='stylesheet' href='../css/footer.css'  type='text/css' />\n";
	echo "\t \t<title>O.T.A.N. - Importer</title>\n";
	enTete2_2();
	echo "\t \t";
	incHeaderAdmin();
	$db = DB::getInstance();
	$lstAnn = $db->getAllAnnee();
	sort($lstAnn);
	echo "\t \t<h1>Importer</h1>\n";
	echo "\t \t<section class=\"encad\">\n";
	corps($lstAnn);
	echo "\n\t \t</section>\n";
	echo "\t \t";
	pied();
	echo "\n\t</body>\n</html>\n";


	function corps($lstAnn)
	{
		echo "\t \t \t<p> Attention tout enregistrement est définitif, pour modifier les données, il faudra le faire directement sur la page visualisation ou supprimer les données puis re-télécharger les données. </p>\n";
		echo "\t \t \t<h2>Fichier Jury/Moyenne</h2>\n";
		selectionFichier($lstAnn);
		if(isset($_POST['submit1']) && isset($_FILES['file'])) 
		{
			
			$chemin_fichier = $_FILES['file']['tmp_name'];
			$annee_selectionnee = isset($_POST['annee']) ? $_POST['annee'] : null;

			if ($annee_selectionnee === null && count($lstAnn) > 0) {
				$annee_selectionnee = $lstAnn[0]->getId_annee();
			}
			if ($annee_selectionnee == 'NouvelleAnnee') {
				$annee_selectionnee = $_POST['nombre'];
			}
			echo $_FILES['file']['name'];
			mettreDansDB($chemin_fichier, $annee_selectionnee);
		}
		echo "<br>\n";
		echo "\t \t \t<h2>Fichier Coef</h2>\n";
		selectionFichier2();
		if( isset($_POST['submit2']) && isset($_FILES['file']) ) 
		{
			$chemin_fichier = $_FILES['file']['tmp_name'];
			echo $_FILES['file']['name'];
			mettreCoef($chemin_fichier);
		}
	}

	function selectionFichier($lstAnn)
	{
		echo "\t \t \t<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
		echo "\t \t \t \t<label for=\"file\">Sélectionner un fichier :</label>\n";
		echo "\t \t \t \t<input type=\"file\" id=\"file\" name=\"file\" accept=\".xlsx\" required><br><br>\n";
		echo "\t \t \t \t<label for=\"annee\">Entrez l'année du fichier :</label>\n";
		echo "\t \t \t \t<select name=\"annee\" onchange=\"afficherOuCacherChamp()\">\n";
		echo "\t \t \t \t \t<option value=\"NouvelleAnnee\">Nouvelle Annee</option>\n";
		foreach ($lstAnn as $annee) {
			echo "\t \t \t \t\t<option value='".$annee->getId_annee()."'>".$annee->getId_annee()."</option>\n";
		}
		echo "\t \t \t \t</select><br><br>\n";
		echo "\t \t \t \t<p id=\"nouvelleAnneeText\" style=\"display:block;\">Nouvelle année:<input type=\"text\" id=\"nombre\" name=\"nombre\" pattern=\"[0-9]+\" required></p><br>";
		echo "\t \t \t \t<input type=\"submit\" name=\"submit1\" class=\"Valid\" value=\"Enregistrer\">\n";
		echo "\t \t \t</form>";
	}

	function selectionFichier2()
	{
		echo "\t \t \t<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
		echo "\t \t \t \t<label for=\"file\">Sélectionner un fichier :</label>\n";
		echo "\t \t \t \t<input type=\"file\" id=\"file\" name=\"file\" accept=\".xlsx\" required><br><br>\n";
		echo "\t \t \t \t<input type=\"submit\" name=\"submit2\" class=\"Valid\" value=\"Enregistrer\" >\n";
		echo "\t \t \t</form>\n";
		// Vérifier si le formulaire a été soumis et si un fichier a été envoyé
		
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
            nombreInput.setAttribute('required', 'required'); // Ajout de l'attribut required
        } else {
            nouvelleAnneeText.style.display = 'none';
            nombreInput.style.display = 'none';
            nombreInput.removeAttribute('required'); // Suppression de l'attribut required
        }
    }
</script>