<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';

if (!empty($_POST)) {
    if (isset($_POST['password'], $_POST['userName'])) {
        $db = connectToDb();

        $userName = filter_input(INPUT_POST, 'userName', FILTER_UNSAFE_RAW);
        $password = $_POST['password'];

        $response = logIn($db, $userName, $password);

        if ($response) {
            session_regenerate_id(true);

            $_SESSION['uid'] = $response['uid'];
            $_SESSION['username'] = $response['username'];
            $_SESSION['name'] = $response['name'];
            header("Location: index.php");
        } else {
            header("Location: index.php?type=login");
        }
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