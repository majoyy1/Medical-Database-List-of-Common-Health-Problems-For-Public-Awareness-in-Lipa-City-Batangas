<?php
// require_once "authdb.php";
require_once "encryption.php";
// require_once "../connection.php";
$security = new encryptionWork();

//Login Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['uname']) && isset($_POST['pass'])) {

        // echo $_POST['uname'] .$_POST['pass'];
        
        try {
            $security->verifyInputCredentials($_POST['uname'], $_POST['pass']);
        } catch (Exception $er) {
            echo "Error :" .$er->getMessage();
        }
        // header("Location: index1.php?loginAuth=1");//0 is error login
        // $result = $temp->checkAllUser();
        // echo json_encode($result, JSON_PRETTY_PRINT)
    }
} 


?>