<?php
/*
Script "mini_chat"
    Par seb Luca
Dernière modification : 26 01 2018
*/
	//connexion a la base de données
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=tp_coursphp;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
?>
<?php 
	/*if(isset($_COOKIE['minichat_pseudo']))
	{
		echo $cookiePseudo = $_COOKIE['minichat_pseudo'];
	}*/
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Mini-chat</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<header>
				<h1>Mini chat</h1>
		</header>
		<section>
			<div id="content">
				<div id="minichat">
					<?php
					$adresse_ip = $_SERVER['REMOTE_ADDR'];

						$reponse = $bdd->query('SELECT * FROM chatsite ORDER BY minichat_id DESC LIMIT 0, 5');
						while ($donnees = $reponse->fetch())
						{
							echo '<p><span class="pseudo">' .strtoupper(strip_tags($donnees['minichat_pseudo'])). '</span> - <span class="message">'.ucfirst(strip_tags($donnees['minichat_message'])).'</span></p>';
						}
					?>
				</div>
				
				<?php header('Refresh: 10;URL=minichat.php'); ?>
				<form action="minichat_post.php" method="POST" enctype="multipart/form-data">
					<fieldset>
						<p><input type="text" name="minichat_pseudo" id="pseudo" value="<?php if(isset($_COOKIE['minichat_pseudo'])) echo ucfirst($_COOKIE['minichat_pseudo']);?>" placeholder="Votre pseudo" /></p>
						<p><textarea name="minichat_message" id="message" value="" placeholder="Votre message"></textarea></p>
						<p><input id="upip" type="hidden" name="upip" value="<?php echo $adresse_ip; ?>" />
						<p><button  type="submit" value="Envoyer">Envoyer</button></p>
					</fieldset>
				</form>
			</div>
	</section>
		<footer>
			<p id="footer"></p>
		</footer>
	</body>
</html>
