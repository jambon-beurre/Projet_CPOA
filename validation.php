<?php include("begin.php"); ?>

<div class='marg'>
	<h1>Merci pour cet achat!</h1>

	<?php
		if(!isset($_GET["over"])){
			$places = reserver($_COOKIE['idMatch'], $_COOKIE['nbPlaces'], $_COOKIE['place']);

			setcookie("placesAttribuees", $places, time()+86400);
	        $_COOKIE["place"] = $places;
			
			header('Location: validation.php?over=1');
		}
		else if(strcmp($_COOKIE["place"], 'Libre') != 0) echo("<p>Votre/Vos numéro(s) de place(s) : " . $_COOKIE["placesAttribuees"] . "</p>");
		else echo("<p>Vous avez réservé ".$_COOKIE["nbPlaces"]." place(s) en emplacement libre.");
	?>
</div>


<?php include("end.php"); ?>