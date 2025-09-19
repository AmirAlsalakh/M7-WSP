<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';
$db = connectToDb();

echo ("<p> Radera Ditt Konto: <p> <br>");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userName = $_POST['userName'];
    $userName = htmlspecialchars($userName);

    $password = $_POST['password'];

    $decision = checkToDeleteUser($db, $userName, $password);

    if ($decision) {
        deleateUser($db);
        header('location: logOut/index.php');
    }
}

?>
<form method="post">
    <label for="usr">Användarnamn</label>
    <input id="usr" type="text" name='userName' required />

    <label for="pwd">Lösenord</label>
    <input id="pwd" type="password" name='password' required />

    <input type="submit" value="Radera Konto" />
</form>