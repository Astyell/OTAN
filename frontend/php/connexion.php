<?php

	// Gestion des Erreurs
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	// Début de la session
	session_start();

	// Importation des fichiers nécessaire
	include('../../backend/php/DB/DB.inc.php');

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
			$mdp = $_POST['mdp'];

			//Récupération de l'identifiant que nous voulons
			$ID   = $DB->getAllIdentifiantWithID($identifiant)->getIdentifiant  ();
			$MDP  = $DB->getAllIdentifiantWithID($identifiant)->getMdp      	();

			//On vérifie s'il existe bien
			if (empty($ID))
			{
				$valid = false;
			}
			else
			{

			}
			
		}

	?>

	<fieldset>
            <h2><a href="https://www.youtube.com/watch?v=Oe3FG4EOgyU" class="hide">Connexion</a></h2>
			<form action="sae203.php" method="post">

				<p>
					<strong>Identifiant</strong> : <input type="text" id="id" name="id" placeholder="Entrez votre identifiant..." required autofocus></br></br>
					<strong>Mot de passe</strong> : <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe..." required></br><br>
				</p>
                <input type="submit" id="button" value="Connexion"></br>

			</form>
			
        <div id="error">
            
        </div>
	</fieldset>
	
</body>
</html>