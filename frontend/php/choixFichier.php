<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function selectionFichier()
{
    echo '<form action="" method="post" enctype="multipart/form-data">
        <label for="file">Sélectionner un fichier :</label><br>
        <input type="file" id="file" name="file" accept=".xlsx"><br><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélectionner un fichier</title>
</head>
<body>

<?php
    selectionFichier();

    require '../../Controleur.php';

    // Vérifier si le formulaire a été soumis et si un fichier a été envoyé
    if(isset($_POST['submit']) && isset($_FILES['file'])) 
    {
        // Récupérer le nom du fichier
        $file_name = $_FILES['file']['name'];

        // Appeler la méthode mettreDansDB() avec le chemin du fichier envoyé
        $chemin_fichier = $_FILES['file']['tmp_name'];
        mettreDansDBControleur($chemin_fichier);
    }
?>
</body>
</html>
