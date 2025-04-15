<?php
require_once "encryption.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['unameReg']) && isset($_POST['passReg'])) {
        echo $_POST['unameReg'] .$_POST['passReg'] ."<br>";
        $process = new encryptionWork();
        $process->AddUsertoDatabase($_POST['unameReg'], $_POST['passReg']);
    }
} 

?>