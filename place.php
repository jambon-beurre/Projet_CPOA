
<?php include("begin.php"); ?>
	
<?php
function errNbPlaces(){
	if(isset($_GET['err']) && $_GET['err'] == 2 && isset($_GET["nbRest"])){
		return true;
	}
	else return false;
}

	if(isset($_GET['id']) && $_GET['id'] != null){
		$prixPlaces = getPrixPlaces($_GET['id']);
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
		    	<select name="place" id="selec">
		    		<?php $nbPlaces = getNbPlacesRestantesEmplacement($_GET["id"]); ?>
		    		<p><option></option></p>
				    <p><option value="A" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'A') == 0) echo("selected"); ?>>A - <?php echo($nbPlaces["A"]); ?> places restantes</p>
					<p><option value="B" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'B') == 0) echo("selected"); ?>>B - <?php echo($nbPlaces["B"]); ?> places restantes</p>
					<p><option value="C" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'C') == 0) echo("selected"); ?>>C - <?php echo($nbPlaces["C"]); ?> places restantes</p>
					<p><option value="E" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'E') == 0) echo("selected"); ?>>E - <?php echo($nbPlaces["E"]); ?> places restantes</p>
					<p><option value="G" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'G') == 0) echo("selected"); ?>>G - <?php echo($nbPlaces["G"]); ?> places restantes</p>
				    <p><option value="H" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'H') == 0) echo("selected"); ?>>H - <?php echo($nbPlaces["H"]); ?> places restantes</p>
					<p><option value="I" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'I') == 0) echo("selected"); ?>>I - <?php echo($nbPlaces["I"]); ?> places restantes</p>
					<p><option value="J" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'J') == 0) echo("selected"); ?>>J - <?php echo($nbPlaces["J"]); ?> places restantes</p>
				    <p><option value="K" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'K') == 0) echo("selected"); ?>>K - <?php echo($nbPlaces["K"]); ?> places restantes</p>
					<p><option value="L" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'L') == 0) echo("selected"); ?>>L - <?php echo($nbPlaces["L"]); ?> places restantes</p>
					<p><option value="N" <?php if(errNbPlaces() && strcmp($_COOKIE["place"], 'N') == 0) echo("selected"); ?>>N - <?php echo($nbPlaces["N"]); ?> places restantes</p>
				</select>
				<div id="display"></div>

				<script>
					var prixPlaces= new Array();
					<?php
					 $numArray=count($prixPlaces);
					 for($i=0;$i<$numArray;$i++){
					  echo "prixPlaces[$i] = ". $prixPlaces[$i] . ";\n";
					 }
					?>
					function show_selected() {
					    var selector = document.getElementById('selec');
					    var value = selector[selector.selectedIndex].value;
					    var i = 0;
					    switch(value){
					    	case 'A':
					    		i = 0;
					    		break;
					    	case 'B':
					    		i = 1;
					    		break;
					    	case 'C':
					    		i = 2;
					    		break;
					    	case 'E':
					    		i = 3;
					    		break;
					    	case 'G':
					    		i = 4;
					    		break;
					    	case 'H':
					    		i = 5;
					    		break;
					    	case 'I':
					    		i = 6;
					    		break;
					    	case 'J':
					    		i = 7;
					    		break;
					    	case 'K':
					    		i = 8;
					    		break;
					    	case 'L':
					    		i = 9;
					    		break;
					    	case 'N':
					    		i = 10;
					    		break;
					    }

					    document.getElementById('display').innerHTML = "<p class = \"middle\"><label class=\"strong\">Prix unitaire : </label>" + prixPlaces[i] + " €</p>";
					}

					document.getElementById('selec').addEventListener('change', show_selected);

				</script>

			</p>
		    <p class="middle"><label class="strong">Nombre(s) de place(s) : </label><input type="number" name="nbPlaces" min="1"></p>
		    <?php
		    	if(isset($_GET['err'])){
		    		if($_GET['err'] == 1){
		    			echo("<p class='err middle'>Veuillez renseigner un emplacement et un nombre de places</p>");
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