
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

    	<div class="selecPlaces">
	    	<p class="middle">
	    		Emplacement : 
		    	<select name="place">
				    <p><option value="1">A</p>
					<p><option value="2">B</p>
					<p><option value="3">C</p>
					<p><option value="4">E</p>
					<p><option value="5">G</p>
				    <p><option value="6">H</p>
					<p><option value="7">I</p>
					<p><option value="8">J</p>
				    <p><option value="9">K</p>
					<p><option value="10">L</p>
					<p><option value="11">N</p>
				</select>
			</p>
		    <p class="middle">Nombre(s) de place(s) : <input type="number" name="nbPlaces"></p>
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