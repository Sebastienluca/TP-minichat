<?php


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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mini chat</title>

<link href="template.css" rel="stylesheet" type="text/css">
</head>

<body>
<h1>TP Mini chat</h1>

<div class="paragraphe"><p>Création minichat</p></div>
<div class="container-fluid">
<div class="form">
<p>Ajouter un message</p>
<form action="minichat_post.php" method="POST" enctype="multipart/form-data" />

<fieldset>
	<div class="form-group">
	 	<label for="pseudo">Votre pseudo</label>
	      <label for="pseudo">Pseudo :</label>
<input type="text" name="pseudo" id="pseudo" value="<?php
 
  if(isset($_COOKIE['pseudo']))
  {
    echo htmlspecialchars($_COOKIE['pseudo']);
  }
   
  ?>"><br>
	</div>
</fieldset>
<fieldset>
	<div class="form-group">
	     <label for="message" title="Votre message">Votre message:</label>  
	      <input name="message" type="text" id="message" />
	</div>
</fieldset>
<button type="submit" name="submit value="Uploader" class="input-btn pull-left">Envoyer votre message</button>
 </p>
    <!-- Recharger la page en appuyant sur le bouton -->
    <p> <a href="javascript:window.location.reload()">Recharger la page</a> </p>
</form>
</div>
<div class="news">
<?php
// On met dans une variable le nombre de messages qu'on veut par page
$nombreDeMessagesParPage = 5; // Essayez de changer ce nombre pour voir :o)
// On récupère le nombre total de messages
$req = $bdd->query('SELECT COUNT(*) AS nb_message FROM chat');
        $donnees = $req->fetch();

$totalDesMessages = $donnees['nb_message'];
// On calcule le nombre de pages à créer
$nombreDePages  = ceil($totalDesMessages / $nombreDeMessagesParPage);
// Puis on fait une boucle pour écrire les liens vers chacune des pages
 
if (isset($_GET['page']))
{
        $page = $_GET['page']; // On récupère le numéro de la page indiqué dans l'adresse
}
else // La variable n'existe pas, c'est la première fois qu'on charge la page
{
        $page = 1; // On se met sur la page 1 (par défaut)
}
  
// On calcule le numéro du premier message qu'on prend pour le LIMIT de MySQL
$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;

$req = $bdd->prepare('SELECT id,pseudo,message,DATE_FORMAT(date_creation, \'%d/%m/%Y \') AS date_creation_fr FROM chat ORDER BY ID DESC LIMIT ' . $premierMessageAafficher . ', ' . $nombreDeMessagesParPage);
	
	$req->execute(array(
		
		));

	while ($donnees = $req->fetch())
		{
 ?>


<p><?php echo htmlspecialchars($donnees['pseudo']); ?>
-
<?php echo nl2br(htmlspecialchars($donnees['message'])); ?> - Posté le : <?php echo htmlspecialchars($donnees['date_creation_fr']); ?>
</p>
<?php
}

	$req->closeCursor(); // Termine le traitement de la requête
echo '<ul class="pagination">
<li><a href="minichat.php"> 1 </a></li>';

for ($i = 2 ; $i <= $nombreDePages ; $i++)
{
   echo '<li><a href="minichat.php?page=' . $i . '">' . $i . '</a></li>
    ';
}

echo '</ul>';
?>
</div>
</div>
</body>
</html>
