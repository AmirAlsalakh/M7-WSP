<?php

/**
 * Anluter till databasen och returnerar ett PDO-objekt
 * @return PDO  Objektet som returneras
 */
function connectToDb()
{
    // Definierar konstanter med användarinformation.
    define('DB_USER', 'egytalk');
    define('DB_PASSWORD', '12345');
    define('DB_HOST', 'mariadb'); // mariadb om docker annars localhost
    define('DB_NAME', 'egytalk');

    // Skapar en anslutning till MySql och databasen egytalk
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $db = new PDO($dsn, DB_USER, DB_PASSWORD);

    return $db;
}

function logIn($db, $userName, $password)
{
    $stmt = $db->prepare("SELECT * FROM user WHERE username = :user");
    $stmt->bindValue(":user", $userName);

    $stmt->execute();

    $response = [];
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            $respons['uid'] = $user['uid'];
            $respons['username'] = $user['username'];

            $respons['name'] = $user['firstname'] . " " . $user['surname'];

            return $response;
        } else {
            return $response;
        }
    } else {
        return $response;
    }
}

function signUp($db, $firstName, $surName, $userName, $password)
{
    $result = true;
    $sqlkod = "INSERT INTO user(uid, firstname, surname, username, password) VALUES(UUID(), :fn, :sn,:user,:pwd)";

    $stmt = $db->prepare($sqlkod);

    $stmt->bindValue(":fn", $firstName, PDO::PARAM_STR);
    $stmt->bindValue(":sn", $surName, PDO::PARAM_STR);
    $stmt->bindValue(":user", $userName, PDO::PARAM_STR);
    $stmt->bindValue(":pwd", $password, PDO::PARAM_STR);

    try {
        $stmt->execute();
        return $result;
    } catch (Exception $e) {
        $result = !$result;
        return $result;
    }
}

function searchFriend($db, $userName)
{
    $sqlkod = "SELECT firstname, surname, username, `uid` FROM user WHERE username LIKE :username AND uid NOT LIKE :uid";

    $stmt = $db->prepare($sqlkod);
    $stmt->bindValue(':username', $userName . "%");
    $stmt->bindValue(':uid', $_SESSION['uid']);


    $stmt->execute();

    $_SESSION['count'] = $stmt->rowCount();

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

function selectPostsFromUser($db)
{
    $sqlkod = "SELECT post.* , user.firstname, user.surname, user.username FROM post NATURAL JOIN user WHERE user.uid = :uid ORDER BY date DESC";

    $stmt = $db->prepare($sqlkod);
    $stmt->bindValue(':uid', $_SESSION['uid']);

    $stmt->execute();

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

function selectPostsFromAll($db)
{
    $sqlkod = "SELECT post.* , user.firstname, user.surname, user.username FROM post NATURAL JOIN user ORDER BY date DESC";
    $stmt = $db->prepare($sqlkod);
    $stmt->execute();

    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

function selectFriend($db)
{
    $sql = "SELECT friend.* , user.firstname, user.surname, user.username FROM `friend` JOIN `user` ON friend.uid2 = user.uid WHERE friend.uid = :uid AND user.uid != :uid ";

    $stmt2 = $db->prepare($sql);
    $stmt2->bindValue(':uid', $_SESSION['uid']);

    $stmt2->execute();

    $posts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

function insertFriend($db, $post)
{
    $stmt = $db->prepare("INSERT INTO friend (firstname, surname, username, uid, uid2) VALUES (:firstname, :surname, :username, :uid, :uid2)");

    $stmt->bindValue(':uid', $_SESSION['uid']);
    $stmt->bindValue(':uid2', $post['uid2']);
    $stmt->bindValue(":firstname", $post['firstName']);
    $stmt->bindValue(":surname", $post['surName']);
    $stmt->bindValue(":username", $post['userName']);
    $stmt->execute();
}

function checkFriend($db, $post)
{
    $result = true;
    $check = $db->prepare("SELECT 1 FROM friend WHERE uid = :uid AND uid2 = :uid2");

    $check->bindValue(':uid', $_SESSION['uid']);
    $check->bindValue(':uid2', $post['uid2']);

    $check->execute();

    if ($check->rowCount() === 0) {
        return $result;
    } else {
        $result = !$result;
        return $result;
    }
}

function saveMsg($db, $msg)
{
    $stmt = $db->prepare("INSERT INTO comment(pid, comment_txt, date, uid) VALUES (:pid, :comment_txt, :date, :uid)");
    $stmt->bindValue(":uid", $_SESSION['uid']);
    $stmt->bindValue(":comment_txt", $msg);
    $stmt->bindValue(":date", date("Y-m-d H:i:s"));
    $stmt->bindValue(":pid", $_POST['pid']);

    $stmt->execute();
}

function checkToDeleteUser($db, $userName, $password)
{
    $stmt1 = $db->prepare("SELECT password FROM user WHERE uid = :uid");
    $stmt1->bindValue(':uid', $_SESSION['uid']);
    $stmt1->execute();

    $user = [];
    if ($stmt1->rowCount() === 1) {
        $user = $stmt1->fetch(PDO::FETCH_ASSOC);

        if ($_SESSION['username'] == $userName) {
            if (password_verify($password, $user['password'])) {
                return $user;
            } else {
                $user = [];
                return $user;
            }
        } else {
            $user = [];
            return $user;
        }
    } else {
        return $user;
    }
}

function deleateUser($db)
{
    $stmt = $db->prepare("DELETE user, comment, friend FROM user LEFT JOIN comment ON user.uid = comment.uid LEFT JOIN friend ON user.uid = friend.uid WHERE user.uid = :uid");
    $stmt->bindValue(':uid', $_SESSION['uid']);
    $stmt->execute();
}

function selectAllMessages($db, $postPid)
{
    $stmtC = $db->prepare("SELECT comment.*, user.firstname, user.surname, user.username FROM comment JOIN user ON comment.uid = user.uid WHERE comment.pid = :pid ORDER BY date ASC");
    $stmtC->bindValue(':pid', $postPid);

    $stmtC->execute();

    $comments = $stmtC->fetchAll(PDO::FETCH_ASSOC);

    return $comments;
}

function saveKlotterMessages($db, $klotter)
{
    $stmt = $db->prepare("INSERT INTO post(uid, post_txt, date) VALUES (:uid , :post_txt, :date)");

    $stmt->bindValue(":uid", $_SESSION['uid']);
    $stmt->bindValue(":post_txt", $klotter);
    $stmt->bindValue(":date", date("Y-m-d H:i:s"));

    $stmt->execute();
}