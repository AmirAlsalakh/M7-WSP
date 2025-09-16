<?php if (session_status() == PHP_SESSION_NONE)

    session_start();

$_SESSION['CSRFKlotterToken'] = bin2hex(random_bytes(32));
$_SESSION['CSRFMessageToken'] = bin2hex(random_bytes(32));

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8">
    <title>EGY Talk</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/../inc/header.php'; ?>

    <main>
        <?php
        if (isset($_SESSION['uid'])) {

            $get = "hem";

            if (isset($_GET['get'])) {
                $get = $_GET['get'];
            }

            if (!empty($_GET)) {
                switch ($get) {
                    case 'flow':
                        include('flow/index.php');
                        break;
                    case 'friends':
                        include('friends/index.php');
                        break;
                    case 'preferences':
                        include('preferences/index.php');
                        break;
                    case 'logOut':
                        header("location: logOut/index.php");
                        break;
                    default:
                    case 'searchFriends':
                        include('searchFriends/index.php');
                        break;
                    case 'user':
                        include('user/index.php');
                        break;
                }
            } else {
                include('user/index.php');
            }
        } else {
            $type = 'signUp';

            if (isset($_GET['type'])) {
                $type = $_GET['type'];
            }

            if (!empty($_GET)) {
                switch ($type) {
                    case 'logIn':
                        include $_SERVER['DOCUMENT_ROOT'] . '/../inc/logIn.php';
                        break;
                    default:
                    case 'signUp':
                        include $_SERVER['DOCUMENT_ROOT'] . '/../inc/signUp.php';
                }
            } else {
                include $_SERVER['DOCUMENT_ROOT'] . '/../inc/signUp.php';
            }
        }
        ?>

    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/../inc/footer.php'; ?>
</body>

</html>