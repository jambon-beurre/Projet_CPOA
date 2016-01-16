<?php
	include("begin.php");
	if($_POST["cp"] != null){
		$reduction = reduction($_POST["cp"]);
		if($reduction>=0){
			setcookie("reduc", $reduction, time()+86400);
        	$_COOKIE["reduc"] = $reduction;
        	header('Location: recapitulatif.php?id='.$_COOKIE["idMatch"].'&red=1');
		}
		else{
		header('Location: recapitulatif.php?id='.$_COOKIE["idMatch"].'&red=-1');
	}
	}
	else{
		header('Location: recapitulatif.php?id='.$_COOKIE["idMatch"].'&red=-1');
	}
?>