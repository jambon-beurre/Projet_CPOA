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

<?php
require('html_table.php');

$bdd = Connect_db();
$SQL_Query = 'insert into Facture values(null)';

$query = $bdd -> prepare($SQL_Query);
$query -> execute();

$SQL_Query = 'select max(idFacture) as m from Facture';

$query = $bdd -> prepare($SQL_Query);
$query -> execute();
$idFacture = 0;
while($line = $query -> fetch()){
        $idFacture = $line["m"];
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$html='
<table border="1">
<tr>
<td width="200" height="50">Tour</td><td width="400" height="50">'.getTour($_COOKIE["jourMatch"]).'</td>
</tr>
<tr>
<td width="200" height="50">Match</td><td width="400" height="50">'.getVs($_COOKIE["idMatch"], $_COOKIE["typeMatch"]).'</td>
</tr>
<tr>
<td width="200" height="50">Court</td><td width="400" height="50">'.getCourt($_COOKIE["idMatch"]).'</td>
</tr>
<tr>
<td width="200" height="50">Emplacement</td><td width="400" height="50">'.$_COOKIE["place"].'</td>
</tr>
<tr>
<td width="200" height="50">Date</td><td width="400" height="50">'.getJour($_COOKIE["jourMatch"]).'</td>
</tr>
<tr>
<td width="200" height="50">Heure</td><td width="400" height="50">'.getHeure($_COOKIE["heureMatch"]).'</td>
</tr>
<tr>
<td width="200" height="50">Nombre de places</td><td width="400" height="50">'.$_COOKIE["nbPlaces"].'</td>
</tr>
<tr>
<td width="200" height="50">Prix total</td><td width="400" height="50">'.$_COOKIE["prix"].' euros</td>
</tr>
</table>';

$pdf->WriteHTML($html);
$pdf->Output("F","./factures/Facture n".$idFacture.".pdf");

?>
<div class='marg'><a href=<?php echo('"pdf.php?pdf='.$idFacture.'"'); ?>>Télécharger la facture</a></div>

<?php include("end.php"); ?>