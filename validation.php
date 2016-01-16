<?php include("begin.php"); ?>

<h1>Merci pour cet achat!</h1>

<?php
	if(!isset($_GET["over"])){
		$places = reserver($_COOKIE['idMatch'], $_COOKIE['nbPlaces'], $_COOKIE['place']);

		setcookie("placesAttribuees", $places, time()+86400);
        $_COOKIE["place"] = $places;
		
		header('Location: validation.php?over=1');
	}
	else echo("<p>Vos/Votre numéro(s) de place(s) : " . $_COOKIE["placesAttribuees"] . "</p>");
?>

<?php include("end.php"); ?>