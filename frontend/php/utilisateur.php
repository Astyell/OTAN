<?php
	/** utilisateur.php
	* @author  : Alizéa Lebaron
	* @since   : 03/04/2024
	* @version : 1.0.0 - 03/04/2024
	*/

	// Reload la page à chaque fois pour les images
	header("Cache-Control: no-cache, must-revalidate");

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
		// On se connecte à la BDD
		$DB = DB::getInstance();

		//On vérifie ce que l'on a à supprimer

		if (isset($_GET['delete']))
		{
			$DB->deleteIdentifiant($_GET['delete']);
		}

		// On vérifie si l'on doit ajouter ou modifier quelque chose
		if (isset($_POST['type']))
		{
			if ($_POST['type'] == "ajout")
			{
				$identifiant= $_POST['identifiant'];
				$mdp  = verifMDP($_POST['mdp' ]);
				$estAdmin = isset($_POST['admin']) ? $_POST['admin'] : 0;
				
				$DB->insertIdentifiant($identifiant, $mdp, $estAdmin);
			}
			if ($_POST['type'] == "modifier")
			{
				if (isset($_POST['valider'])) 
				{
					$identifiant= $_POST['identifiant'];
					$mdp  = verifMDP($_POST['mdp' ]);
					$estAdmin = isset($_POST['admin']) ? $_POST['admin'] : 0;
					
					$DB->updateIdentifiant($identifiant);
					$DB->updateMDP($MDP);
					$DB->updateIdentifiant($identifiant); //TODO
				}
				
			}
			
		}

		// Afficher le header admin (dans importer seul l'admin peut venir)
		incHeaderAdmin();
	?>

	<div class="utilisateur">

		<h1>Listes des utilisateurs</h1>

		<?php
			// On récupère les users
			$user = $DB->getAllIdentifiant();

			// On génère un tableau avec leurs informations
			genererTableau($user);

		?>

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
		$DB = DB::getInstance();

		echo "<table>";

			echo "<tr>
					<th>Numéro</th>
					<th>Identifiant</th>
					<th>Mot de passe</th>
					<th>est Administrateur</th>
					<th colspan=2>Gestion</th>
				
				</tr>";
			
			foreach ($user as $u) 
			{
				$estAdmin = $u->getEstAdmin	() == 1 ? "<input type='checkbox' name='estAdmin' disabled checked>" : "<input type='checkbox' name='estAdmin' disabled>";

				echo "<tr>";

					echo "<td>" . $u->getId	()   ."</td>";
					echo "<td>" . $u->getIdentifiant	()   ."</td>";
					echo "<td> &nbsp </td>";
					echo "<td>" . $estAdmin   ."</td>";
					echo "<td> <a href='?delete=". $u->getId	() ."'>Supprimer</a> </td>";
					echo "<td> <a href='?modifier=". $u->getId	() ."'>Modifier</a> </td>";

				echo "</tr>";
			}

			$IdMax = $DB->getMaxId() + 1;

			echo "<form action=\"utilisateur.php\" method=\"post\">";

				echo 
				"<tr>
					<input type='hidden' name='type' value='ajout'>
					<td><input type='number' name='id' min=0 disabled value=$IdMax></td>
					<td><input type='text' name='identifiant'  required pattern = '^[A-Za-z0-9]+$'></td>
					<td><input type='text' name='mdp'  required></td>
					<td><input type='checkbox' name='admin'></td>
					<td><input type='reset' value='Annuler D:'></td>
					<td><input type='submit' value='Ajouter	 :D'></td>
				</tr>";

			echo "</form>";

		echo "</table>";
			
	}

?>
