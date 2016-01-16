
<?php include("begin.php"); ?>
	
<?php
function errNbPlaces(){
	if(isset($_GET['err']) && $_GET['err'] == 2 && isset($_GET["nbRest"])){
		return true;
	}
	else return false;
}

	if(isset($_GET['id']) && $_GET['id'] != null){
?>
<div>
<P class="middle">
<img src="images/stade.png" alt="Bannière" height="500" width="700">
</p>
</div>

<div class="milieu">

    <form <?php echo("action=\"recapitulatif.php?id=". $_GET['id'] ."\""); 	?> method="POST">

    	<div>
    		<p class="middle"><label class="strong">Nombre de places restantes : </label><?php echo(getNbPlacesRestantes($_GET["id"])); ?></p>
	    	<p class="middle">
	    		<label class="strong">Emplacement : </label>
		    	<select name="place">
				    <p><option value="A" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'A') == 0) echo("selected"); ?>>A</p>
					<p><option value="B" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'B') == 0) echo("selected"); ?>>B</p>
					<p><option value="C" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'C') == 0) echo("selected"); ?>>C</p>
					<p><option value="E" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'E') == 0) echo("selected"); ?>>E</p>
					<p><option value="G" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'G') == 0) echo("selected"); ?>>G</p>
				    <p><option value="H" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'H') == 0) echo("selected"); ?>>H</p>
					<p><option value="I" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'I') == 0) echo("selected"); ?>>I</p>
					<p><option value="J" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'J') == 0) echo("selected"); ?>>J</p>
				    <p><option value="K" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'K') == 0) echo("selected"); ?>>K</p>
					<p><option value="L" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'L') == 0) echo("selected"); ?>>L</p>
					<p><option value="N" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'N') == 0) echo("selected"); ?>>N</p>
				</select>
			</p>
		    <p class="middle"><label class="strong">Nombre(s) de place(s) : </label><input type="number" name="nbPlaces" min="1"></p>
		    <?php
		    	if(isset($_GET['err'])){
		    		if($_GET['err'] == 1){
		    			echo("<p class='err middle'>Veuillez renseigner un nombre de places</p>");
		    		}
		    		else if(errNbPlaces()){
		    			echo("<p class='err middle'>Il n'y a plus que ".$_GET["nbRest"]." places restantes pour cet emplacement.</p>");
		    		}
		    	}
		    ?>
		    <p class="middle"><button type="submit">Valider</button></p>
		</div>
	</form>
 </div>
 
<?php
}
else echo("<p>Erreur dans l'URL");
?>

<?php include("end.php"); ?>