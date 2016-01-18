<?php


require('html_table.php');

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$html='<table border="1">
<tr>
<td width="200" height="30">Tour</td><td width="200" height="30">'.getTour($_COOKIE["jourMatch"]).'</td>
</tr>
<tr>
<td width="200" height="30">Match</td><td width="200" height="30">'.getVs($_COOKIE["idMatch"], $_COOKIE["typeMatch"]).'</td>
</tr>
<tr>
<td width="200" height="30">Court</td><td width="200" height="30">'.getCourt($_COOKIE["idMatch"]).'</td>
</tr>
<tr>
<td width="200" height="30">Emplacement</td><td width="200" height="30">'.$_COOKIE["place"].'</td>
</tr>
<tr>
<td width="200" height="30">Nombre de places</td><td width="200" height="30">'.$_COOKIE["nbPlaces"].'</td>
</tr>
<tr>
<td width="200" height="30">Date</td><td width="200" height="30">'.getJour($_COOKIE["jourMatch"]).'</td>
</tr>
<tr>
<td width="200" height="30">Heure</td><td width="200" height="30">'.getHeure($_COOKIE["heureMatch"]).'</td>
</tr>
<tr>
<td width="200" height="30">Prix</td><td width="200" height="30">'.$_COOKIE["prix"].'</td>
</tr>
</table>';

$pdf->WriteHTML($html);
$pdf->Output();
?>
