<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';

session_start();

if (isset($_POST)) {
    if ($_SESSION['CSRFKlotterToken'] === $_POST['CSRFKlotterToken']) {
        $db = connectToDb();

        $klotter = $_POST['klotter'];
        $klotter = htmlspecialchars($klotter);

        $save = saveKlotterMessages($db, $klotter);

        header("location: ../index.php");
    } else {
        header("location: ../blockerad.php");
    }
}