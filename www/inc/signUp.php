<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';

if (!empty($_POST)) {
    if (isset($_POST['firstName']) && isset($_POST['surName']) && isset($_POST['userName']) && isset($_POST['password'])) {
        $db = connectToDb();

        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
        $surName = filter_input(INPUT_POST, 'surName', FILTER_SANITIZE_SPECIAL_CHARS);
        $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $result = signUp($db, $firstName, $surName, $userName, $password);

        if ($result) {
            header('Location: index.php?type=signUp');
        } else {
            header('Content-Type: text/html; charset=utf-8');
            echo "<p>Kunde inte lägga till användaren. Kontrollera användarnamnet</p>";
            echo "<a href = 'index.php?type=signUp'>Försök igen</a>";
        }
    }
}
?>

<aside>
    <img src="/images/mobile.png" alt="Mobiltelefon" width="240" />
</aside>
<section>
    <h2>Skapa konto på EGY Talk</h2>
    <form method="post">
        <label for="fn">Förnamn</label>
        <input id="fn" type="text" name='firstName' required />

        <label for="ln">Efternamn</label>
        <input id="ln" type="text" name='surName' required />

        <label for="usr">Användarnamn</label>
        <input id="usr" type="text" name='userName' required />

        <label for="pwd">Lösenord</label>
        <input id="pwd" type="password" name='password' required />

        <input type="submit" value="Skapa Konto" />
    </form>

    <p class="center">eller</p>

    <button onclick="window.location.href='index.php?type=logIn'">Login</button>
</section>