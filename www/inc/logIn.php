<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../metod/logInMetod.php';

if (!empty($_POST)) {
    $username = $_POST['userName'] ?? "";
    $password = $_POST['password'] ?? "";

    $auth = new UserAuth();
    $user = $auth->login($username, $password);

    if ($user) {
        header("Location: index.php");
    } else {
        header("Location: index.php?type=login");
    }
}
?>

<aside>
    <img src="/images/mobile.png" alt="Mobiltelefon" width="240" />
</aside>

<section>
    <h2>Logga in till EGY Talk</h2>
    <form method="post">
        <label for="usr">Användarnamn</label>
        <input id="usr" type="text" name='userName' required />

        <label for="pwd">Lösenord</label>
        <input id="pwd" type="password" name='password' required />

        <input type="submit" value="Logga in" />
    </form>
    <p class="center">eller</p>
    <button onclick="location.href='index.php?type=signUp'">Registrera</button>
</section>