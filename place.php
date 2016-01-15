
<?php include("begin.php"); ?>
	
<?php
	if(isset($_GET['id']) && $_GET['id'] != null){
?>
<div>
<P style="text-align:center">
<img src="images/stade.png" alt="Bannière" height="500" width="700" a>
</p>
</div>

<div class="milieu">

    <form <?php echo("action=\"recapitulatif.php?id=". $_GET['id'] ."\""); 	?> method="POST">

    	<div>
    		<p class="middle"><label class="strong">Nombre de places restantes : </label><?php echo(getNbPlacesRestantes($_GET["id"])); ?></p>
	    	<p class="middle">
	    		<label class="strong">Emplacement : </label>
		    	<select name="place">
				    <p><option value="A">A</p>
					<p><option value="B">B</p>
					<p><option value="C">C</p>
					<p><option value="E">E</p>
					<p><option value="G">G</p>
				    <p><option value="H">H</p>
					<p><option value="I">I</p>
					<p><option value="J">J</p>
				    <p><option value="K">K</p>
					<p><option value="L">L</p>
					<p><option value="N">N</p>
				</select>
			</p>
		    <p class="middle"><label class="strong">Nombre(s) de place(s) : </label><input type="number" name="nbPlaces"></p>
		    <?php
		    	if(isset($_GET['err'])){
		    		echo("<p class='err'>Veuillez renseigner un nombre de places</p>");
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