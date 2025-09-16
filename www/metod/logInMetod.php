<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../model/dbFunctions.php';

class UserAuth
{
    public function login($userName, $password)
    {
        if (isset($_POST['password'], $_POST['userName'])) {
            $db = connectToDb();

            $userName = filter_input(INPUT_POST, 'userName', FILTER_UNSAFE_RAW);
            $password = $_POST['password'];

            $result = logIn($db, $userName, $password);

            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
}