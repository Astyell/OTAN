<?php
	/** visualisation.php
	* @author  : Alizéa Lebaron, Justine BONDU
	* @since   : 26/03/2024
	* @version : 1.0.5 - 03/02/2024
	*/

	// Affichage des erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Début de la session
    session_start();

	// Vérification que la session existe bien
	if (!isset($_SESSION['id'])) 
	{
        header('Location: connexion.php');
        exit();
    }

	// Importation
	include ("fctAux.inc.php");
	require ("../../backend/php/modele/visuFichier.php");

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
	<link rel='stylesheet' href='../css/visuTest.css' type='text/css' />
	<link rel='stylesheet' href='../css/header.css' type='text/css' />
	<link rel='stylesheet' href='../css/footer.css' type='text/css' />
	<title>O.T.A.N. - Visualisation</title>
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
        
		<?php

			$db = DB::getInstance();
			$lstAnn = $db->getAllAnnee();
			$lstSem = $db->getAllSemestre();
			sort($lstAnn);
			sort($lstSem);
            echo "<select name=\"fichier\">";
            foreach ($lstAnn as $annee) 
			{
                echo "<optgroup label=".$annee->getId_annee().">\n";
                foreach ($lstSem as $semestre) 
				{
                    if ($semestre->getId_annee() == $annee->getId_annee())
                    {
                        echo "<option value='".$annee->getId_annee(). "_" .$semestre->getId_semestre()."_Jury"."'>".$annee->getId_annee()."_S".$semestre->getId_semestre()."_Jury"."</option>\n";
                        
                        if($semestre->getId_semestre()%2==1)
                        {
                            echo "<option value='".$annee->getId_annee(). "_" .$semestre->getId_semestre()."_Commission"."'>".$annee->getId_annee()."_S".$semestre->getId_semestre()."_Commission"."</option>\n";
                        }
                    }
                }
            }
            echo "</select><input type=\"submit\" value=\"Consulter\">";
            ?>
		</form>
	</div>
	
	<?php

		isset($_GET['fichier']) ? $class = "affiche" : $class = "visu";
	
	?>
	
	<div class="<?php echo $class;?>"> 
		
		<?php
			if (!isset($_GET['fichier'])) { echo "<p class='vide'> Aucun fichier sélectionné pour le moment </p> " ; }
			else
			{
				$fichier = explode("_", $_GET['fichier']);

				//echo $fichier[2]; //debug

				if ($fichier[2] == "Jury")
				{
					afficheJury($fichier[1], $fichier[0]);
				}
				else
				{
					affichePvCommission($fichier[1], $fichier[0]);
				}
			}

		?>
	</div>
	
	
	<?php
		pied();
	?>
</body>
</html>

	

