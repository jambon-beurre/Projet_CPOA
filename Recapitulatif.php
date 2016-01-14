
 <?php include("begin.php"); ?>

<?php
    if(isset($_POST["place"]) && isset($_POST["nbPlaces"]) && $_POST["place"]!=null && $_POST["nbPlaces"]!=null && isset($_GET['id']) && $_GET['id'] != null){
        setcookie("nbPlaces", $_POST['nbPlaces'], time()+86400);
        setcookie("place", $_POST['place'], time()+86400);
        setcookie("idMatch", $_GET['id'], time()+86400);
    }
    else{
        header('Location: place.php?id='.$_GET["id"]."&err=1");
    }

    /*$bdd = Connect_db();

    $SQL_Query = 'SELECT idMatch as id, typeMatch as t FROM Matchs order by jourMatch, heureMatch';

    $query = $bdd -> prepare($SQL_Query);
    $query -> execute();
*/

?>
    <div class="contour">


        <p>
            <label for="nom">Tour :</label>
        </p>
        <p>
            <label for="courriel">Match :</label>
        </p>
        <p>
            <label>Court :</label>
        </p>
        <p>
            <label>Nombre de places :</label>
        </p>
        <p>
            <label>Date :</label>
        	<label>Heure :</label>
        </p>
        <p>
            <label>Emplacement :</label>
        </p>

        <form action="Recapitulatif.php" method="post">
            <p>
                <label>Code Promo :</label>
                <input type="text" id="cp" name="cp" />
            </p>
            <p>
                <button type="submit">Valider le code promotionnel</button>
            </p>
        </form>

        <p>
            <label>Prix :</label>
        </p>

        <button type="button" onclick="location.href='validation.php';">Valider</button>
    </div>
    <p><a <?php echo ('href="place.php?id='.$_GET["id"].'"'); ?>>Retour à la page précédente</a></p>

	
	
<?php include("end.php"); ?>