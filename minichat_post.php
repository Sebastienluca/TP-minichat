<?php
setcookie('pseudo', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true); // On écrit un cookie

// connexion à la base de donnée
try {

	$bdd = new PDO('mysql:host=localhost;dbname=tpminichat;charset=utf8', 'root', '',
		array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ));
	
	} catch (Execption $e) {

	die('Erreur : '.$e->getMessage());
}


if (isset($_POST['message']) AND !empty($_POST['message'])) { 


	// On ajoute un message
$req = $bdd->prepare('
	INSERT INTO chat( pseudo, message, date_creation) 
	VALUES (:pseudo, :message, NOW())');

$req->execute(array(

    
    'pseudo' => $_POST['pseudo'],
    'message' => $_POST['message'],
    

    ));

header('Location: minichat.php');

	}else{

			
			header('Location: minichat.php');

	}



?>

