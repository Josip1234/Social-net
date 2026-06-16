<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Social net old first version</title>
    <?php include "functions.php";
    loggedUsersOnly();
    echo cssIncludes(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo jsIncludes(); ?>
</head>

<?php echo printBodyOnMouseOverAndOnLoadForForum(); ?>
<div class="con">
    <nav>
        <?php include "navigacija.php";
        include "classes/konfiguracija.php";
        ?>
    </nav>

</div>
<?php
echo dropdownMenu();
echo printCalendar();
echo printPictures();
echo printVideos();
echo printCurrencyRate();
?>
<div class="pravila">
    <section>
        <h2>Ovdje počinje forum</h2>
        <input type="button" value="New Topic" onClick="displayNew()">
        <input type="button" value="List exist topics" onClick="displayExist()">
        <div id="Kreiraj">
            <form action="konfiguracija.php" method="post">
                <label>User:</label><br>
                <input type="text" name="Korisnik" value="<?php echo $_SESSION['username'] ?>" />
                <br>
                <label>Topic:</label><br>
                <input type="text" name="Tema"></br>
                <input type="submit" name="Add new Theme" />
                <input type="button" value="Hide form" onClick="hideNew()">
            </form>

            <div id="teme">
                <h3>List of exist Topics</h3>
                <ul>
                    <?php
                    include "dbconn.php";

                    $sql  = "SELECT email,broj_teme,naziv_teme FROM teme";
                    $a = mysqli_query($dbc, $sql);
                    while ($ro = mysqli_fetch_array($a)) {
                        $tema = new Tema(0, $_SESSION["username"], $ro["naziv_teme"]);
                        $tema->setKorisnik($ro["email"]);
                        ($ro["broj_teme"] != null) ? $tema->setBroj($ro["broj_teme"]) : rand();
                        $tema->ispisiTemu();
                    }

                    /*
    	<li><a href="#" onClick="displaySubtopics()">Topic 1</a></li>
    	<li><a href="#" onClick="displaySubtopics()">Topic 2</a></li>
    	<li><a href="#" onClick="displaySubtopics()">Topic3</a></li>
	*/
                    ?>
                </ul>
                <input type="button" value="Hide topics" onClick="hideTopics()">
                <!--<input type="button" value="Display subtopics" onClick="displaySubtopics()">-->
            </div>

            <div id="podteme">
                <h2>SubTopic: Topic number</h2>
                <?php
                $naziv = $tema->getNazivTeme();
                $sql  = "SELECT korisnik,brojpodteme,nazivpodteme,nazivteme FROM podteme WHERE nazivteme='$naziv'";
                $a = mysqli_query($dbc, $sql);
                while ($ro = mysqli_fetch_array($a)) {
                    $podtema = new Podtema($ro["nazivpodteme"]);
                    $podtema->setKorisnik($ro["korisnik"]);
                    $podtema->setTema($ro["nazivteme"]);
                    $podtema->ispis2();
                }
                mysqli_close($dbc);
                ?>
                <ul>
                    <li><a href="#">Subtopic 1</a></li>
                    <li><a href="#">SubTopic 2</a></li>
                    <li><a href="#">SubTopic3</a></li>

                </ul>
                <input type="button" value="Hide subtopics" onClick="hideSubtopics()">
            </div>
    </section>

</div>
<?php
echo printFooter();
?>
</body>

</html>