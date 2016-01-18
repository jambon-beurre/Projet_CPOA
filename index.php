<?php
include("begin.php");

?>
<h1 class='middle'>Planning des matchs</h1>
<table>
	<col>
	<col>
	<col>
	<col>
	<col>
	<col>
	<col>
	<tr>
		<th>Lundi</th>
		<th>Mardi</th>
		<th>Mercredi</th>
		<th>Jeudi</th>
		<th>Vendredi</th>
		<th>Samedi</th>
		<th>Dimanche</th>
	</tr>
	
	<?php
		echo afficherTableau();
	?>

</table>
</h1>

<?php
include("end.php");
?>