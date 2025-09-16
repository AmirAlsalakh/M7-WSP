<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../metod/signUpMetod.php';

if (!empty($_POST)) {
    $fname = $_POST['firstName'] ?? "";
    $lname = $_POST['surName'] ?? "";
    $uname = $_POST['userName'] ?? "";
    $password = $_POST['password'] ?? "";

    $user = new User($fname, $lname, $uname, $password);
    $user->save();
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