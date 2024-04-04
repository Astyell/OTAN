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
					$id = $_POST['idModif'];
					$identifiant= $_POST['identifiantModif'];
					$mdp  = verifMDP($_POST['mdpModif' ]);
					$estAdmin = isset($_POST['estAdminModif']) ? $_POST['estAdminModif'] : 0;
					
					$DB->updateIdentifiant($id, $identifiant, $mdp, $estAdmin);
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

		$npModif = -1;

		if (isset($_GET['modifier']))
		{
			$npModif = $_GET['modifier'];
		}

		echo "<table>";

			echo "<tr>
					<th>Numéro</th>
					<th>Identifiant</th>
					<th>Mot de passe</th>
					<th>Administrateur</th>
					<th colspan=2>Gestion</th>
				
				</tr>";
			
			foreach ($user as $u) 
			{
				if ($u->getId() == $npModif)
				{
					$estAdmin = $u->getEstAdmin	() == 1 ? "<input type='checkbox' name='estAdminModif' checked>" : "<input type='checkbox' name='estAdminModif'>";
					$idAct = $u->getId();
					$idenAct = $u->getIdentifiant();

					echo "<form action=\"utilisateur.php\" method=\"post\">";

					echo "<tr>

						<input type='hidden' name='type' value='modifier'>
						<input type='hidden' name='idModif' value=$idAct>
						<td>$idAct</td>
						<td><input type='text' name='identifiantModif' value='$idenAct'  required pattern = '^[A-Za-z0-9]+$'></td>
						<td><input type='password' name='mdpModif'  required></td>
						<td>$estAdmin</td>
						<td><input type='reset' name='annuler' value='Annuler'></td>
						<td><input type='submit'name='valider' value='Modifier'></td>

					</tr>";

					echo "</form>";
				}
				else
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
			}

			$IdMax = $DB->getMaxId() + 1;

			echo "<form action=\"utilisateur.php\" method=\"post\">";

				echo 
				"<tr>
					<input type='hidden' name='type' value='ajout'>
					<td>&nbsp</td>
					<td><input type='text' name='identifiant'  required pattern = '^[A-Za-z0-9]+$'></td>
					<td><input type='password' name='mdp'  required></td>
					<td><input type='checkbox' name='admin'></td>
					<td><input type='reset' value='Annuler'></td>
					<td><input type='submit' value='Ajouter'></td>
				</tr>";

			echo "</form>";

		echo "</table>";
			
	}

?>
