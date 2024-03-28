<?php
	/** connexion.php
	* @author  : Alizéa Lebaron
	* @since   : 27/03/2024
	* @version : 1.0.0 - 28/03/2024
	*/

	// Gestion des Erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Début de la session
	session_start();

	// Importation des fichiers nécessaire
	include('../../backend/php/DB/DB.inc.php');
	include('fctAux.inc.php');

	$DB = DB::getInstance();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author"   content="Alizéa LEBARON" />
	<link rel="stylesheet" href="../css/connexion.css">
	<title>O.T.A.N - Connexion</title>
</head>
<body>

	<?php
		//On initialise à vrai le fait est que la connexion est bonne
		$valid = true;

		//Si on a rempli le formulaire on test la connexion
		if (!empty($_POST))
		{
			$identifiant = $_POST['id'];
			$mdp = verifMDP($_POST['mdp']);

			//Récupération de l'identifiant que nous voulons s'il existe
			try 
			{
				$mdpDB = $DB->getAllIdentifiantWithID($identifiant)[0]->getMDP         ();
				$droit = $DB->getAllIdentifiantWithID($identifiant)[0]->getEstAdmin	   ();
				
			} 
			catch (\Throwable $th) 
			{
				// La donnée n'est pas présente dans la base de donnée
				$valid = false;
			}

			if ($mdp != $mdpDB)
			{
				//Le mot de passe est invalide
				$valid = false;
			}

			// Si après toutes les vérifications valid est toujours true alors on peut se connecter
			if ($valid)
			{
				// On enregistre les données importantes dans la session
                $_SESSION['id'] = $identifiant;
				$_SESSION['droit'] = $droit;

				// On amène à la page de visualisation
                header('Location: visualisation.php');
                exit();
			}
			
		}

	?>

	<fieldset>
            <h2><a href="https://www.youtube.com/watch?v=Oe3FG4EOgyU" class="hide">Connexion</a></h2>
			<form action="connexion.php" method="post">

				<p>
					<input class="text" type="text" id="id" name="id" placeholder="Identifiant" required autofocus></br></br>
					<input class="text" type="password" id="mdp" name="mdp" placeholder="Mot de passe" required></br><br>
				</p>
				
                <input type="submit" id="button" value="Connexion"></br>

			</form>
			
        <div id="error">
            
			<?php

				if (!$valid) {echo "<p>L'identifiant ou le mot de passe est incorrect.</p>";}

			?>

        </div>
	</fieldset>
	
</body>
</html>