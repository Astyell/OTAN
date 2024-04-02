<?php
    /** deconnexion.php
	* @author  : Alizéa Lebaron
	* @since   : 28/03/2024
	* @version : 1.0.0 - 28/03/2024
	*/

	// Destruction de la session
    session_start();
    session_unset();
    session_destroy();

	// Retour à la page de connexion
    header('Location: connexion.php');
    exit();
?>