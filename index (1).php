<?php
include("begin.php");

?>

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

<?php
include("end.php");
?>