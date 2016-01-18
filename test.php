<?php
include("begin.php");

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

$html='<table border="1">
<tr>
<td width="200" height="30">cell 1</td><td width="200" height="30" bgcolor="#D0D0FF">cell 2</td>
</tr>
<tr>
<td width="200" height="30">cell 3</td><td width="200" height="30">cell 4</td>
</tr>
</table>';

$pdf->WriteHTML($html);
$pdf->Output("F","./factures/Facture n".$idFacture.".pdf");

?>
<a href=<?php echo('"pdf.php?pdf='.$idFacture.'"'); ?>>Télécharger la facture</a>

<?php
include("end.php");
?>