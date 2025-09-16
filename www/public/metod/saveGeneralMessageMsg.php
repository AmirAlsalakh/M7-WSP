<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';

session_start();

if ($_SESSION['CSRFMessageToken'] === $_POST['CSRFMessageToken']) {
    $db = connectToDb();

    $msg = $_POST['message'];
    $msg = htmlspecialchars($msg);

    $save = saveMsg($db, $msg);

    header("location: ../index.php?get=flow");
} else {
    header("location: ../blockerad.php");
}