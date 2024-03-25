<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>S.A.T.A.N. - Connexion</title>
</head>
<body>

	<fieldset>
            <h2><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="hide">Connexion</a></h2>
			<form action="sae203.php" method="post">

				<p>
					<strong>Email</strong> : <input type="text" id="email" name="email" placeholder="Entrez votre email..." required autofocus></br></br>
					<strong>Mot de passe</strong> : <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe..." required></br><br>
				</p>
                <input type="submit" id="button" value="Connexion"></br>
                
                <p class="small">Vous n'avez pas de compte?</p><a href="inscription.php" class ="small">Inscrivez-vous !</a>

			</form>
			
        <div id="error">
            
        </div>
	</fieldset>
	
</body>
</html>