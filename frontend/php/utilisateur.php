<?php
	/** utilisateur.php
	* @author  : Alizéa Lebaron
	* @since   : 03/04/2024
	* @version : 1.0.0 - 03/04/2024
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
	<link rel="stylesheet" href="../css/user.css">
	<link rel='stylesheet' href='../css/footer.css' type='text/css' />
	<link rel="stylesheet" href="../css/header.css">

	<title>O.T.A.N. - Gestion des utilisateurs</title>
</head>

<body>
	<?php
		// Afficher le header admin (dans importer seul l'admin peut venir)
		incHeaderAdmin();
	?>

	<div class="utilisateur">

		<h1>Listes des utilisateurs</h1>



	</div>

	<?php
		// Afficher le footer
		pied();
	?>

</body>

</html>

<?php

	function genererTableau ($user)
	{
		echo "<table>";

			echo "<tr>
					<th>Identifiant</th>
					<th colspan=2>Gestion</th>
				
				</tr>";
			
			foreach ($user as $u) 
			{
				echo "<tr>";

					echo "<td>" . $u->getIdCli()   ."</td>";
					echo "<td> <a href='?delete=". $u->getIdCli() ."'>Supprimer</a> </td>";
					echo "<td> <a href='?modifier=". $u->getIdCli() ."'>Modifier</a> </td>";

				echo "</tr>";
			}
			
	}

?>
