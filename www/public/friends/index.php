<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';
$db = connectToDb();

echo ('<h1> Dina kompisar: <h1> <br>');

if (!empty($_POST['uid2'])) {
    $post = $_POST;

    $check = checkFriend($db, $post);
    if ($check) {
        $getFriend = insertFriend($db, $post);
    }else{
        header('location: index.php?get=friends');
    }
}

$posts = selectFriend($db);

if (count($posts) === 0) {
    echo "<p>Du har inga kompisar ännu.</p>";
} else {
    foreach ($posts as $post) {
        echo "<p>Kompis:</p>";

        echo "<p>Förnamn: " . htmlspecialchars($post['firstname']) . "</p>";

        echo "<p>Efternamn: " . htmlspecialchars($post['surname']) . "</p>";

        echo "<p>Användarnamn: " . htmlspecialchars($post['username']) . "</p>";

        echo "----------------------------------------------<br>";
    }
}