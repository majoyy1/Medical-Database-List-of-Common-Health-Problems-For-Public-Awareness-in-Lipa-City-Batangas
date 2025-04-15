<?php
// require_once "authdb.php";
require_once "encryption.php";
// require_once "../connection.php";
$security = new encryptionWork();

//Login Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['uname']) && isset($_POST['pass'])) {
        echo $_POST['uname'] .$_POST['pass'];
        $security->verifyInputCredentials($_POST['uname'], $_POST['pass']);

        // $result = $temp->checkAllUser();
        // echo json_encode($result, JSON_PRETTY_PRINT)
    }
} 


?>