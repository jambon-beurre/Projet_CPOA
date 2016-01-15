
 <?php include("begin.php"); ?>

<?php
    if(isset($_POST["place"]) && isset($_POST["nbPlaces"]) && $_POST["place"]!=null && $_POST["nbPlaces"]!=null && isset($_GET['id']) && $_GET['id'] != null){
        setcookie("nbPlaces", $_POST['nbPlaces'], time()+86400);
        $_COOKIE["nbPlaces"] = $_POST['nbPlaces'];
        setcookie("place", $_POST['place'], time()+86400);
        $_COOKIE["place"] = $_POST['place'];
        setcookie("idMatch", $_GET['id'], time()+86400);
        $_COOKIE["idMatch"] = $_GET['id'];
    }
    else{
        header('Location: place.php?id='.$_GET["id"]."&err=1");
    }

    $bdd = Connect_db();

    $SQL_Query = 'SELECT jourMatch as j, heureMatch as h, typeMatch as t FROM Matchs WHERE idMatch = ' .$_COOKIE["idMatch"];

    $query = $bdd -> prepare($SQL_Query);
    $query -> execute();

    while($line = $query -> fetch()){
        setcookie("jourMatch", $line["j"], time()+86400);
        $_COOKIE["jourMatch"] = $line["j"];
        setcookie("heureMatch", $line["h"], time()+86400);
        $_COOKIE["heureMatch"] = $line["h"];
        setcookie("typeMatch", $line["t"], time()+86400);
        $_COOKIE["typeMatch"] = $line["t"];
    }

?>
    <div class="contour">
        <p>
            <label class = 'strong'>Tour : </label><?php echo(getTour($_COOKIE["jourMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Match : </label><?php echo(getVs($_COOKIE["idMatch"], $_COOKIE["typeMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Court : </label><?php echo(getCourt($_COOKIE["idMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Emplacement : </label><?php echo($_COOKIE["place"]); ?>
        </p>
        <p>
            <label class = 'strong'>Nombre de places : </label><?php echo($_COOKIE["nbPlaces"]); ?>
        </p>
        <p>
            <label class = 'strong'>Date : </label><?php echo(getJour($_COOKIE["jourMatch"])); ?>
        </p>
        <p>
            <label class = 'strong'>Heure : </label><?php echo(getHeure($_COOKIE["heureMatch"])); ?>
        </p>

        <form action="Recapitulatif.php" method="post">
            <p>
                <label class = 'strong'>Code Promo :</label>
                <input type="text" id="cp" name="cp" />
            </p>
            <p>
                <button type="submit">Valider le code promotionnel</button>
            </p>
        </form>

        <p>
            <label class = 'strong'>Prix :</label>
        </p>

        <button type="button" onclick="location.href='validation.php';">Valider</button>
    </div>
    <p><a class="noStyle"<?php echo ('href="place.php?id='.$_GET["id"].'"'); ?>>Retour à la page précédente</a></p>

	
	
<?php include("end.php"); ?>