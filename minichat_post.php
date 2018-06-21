<?php
/*
Script "mini_chat"
	Par seb Luca
Dernière modification : 26 01 2018
*/
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=tp_coursphp;charset=utf8', 'root', 'root');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}

	setcookie('minichat_pseudo',$_POST['minichat_pseudo'], time() + 365*24*3600, null, null, false, true); // On écrit un cookie
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Post</title>
	</head>
	<body>
		<?php
			//print_r();
			if(empty($_POST['minichat_pseudo']) OR empty($_POST['minichat_message']))
			{
				echo 'Le message n\'a pas été ajouté !';
//time code php a intégrer
//header('Location: minichat.php');

			} else {
				// Insertion du message à l'aide d'une requête préparée
				$req = $bdd->prepare('INSERT INTO chatsite (minichat_pseudo, up_ip, minichat_message) VALUES(?, ?, ?)');
				$req->execute(array(
				$_POST['minichat_pseudo'],
				$_POST['upip'],
				$_POST['minichat_message']
				));
				echo 'Le message a bien été ajouté !';
				
//time code php a intégrer
				// Puis rediriger
				header('Location: minichat.php');
			}
		?>
	</body>
</html>

