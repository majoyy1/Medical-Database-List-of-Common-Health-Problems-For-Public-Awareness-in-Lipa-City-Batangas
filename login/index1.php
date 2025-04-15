<?php
require_once "encryption.php";
$security = new encryptionWork();

//Login Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['uname']) && isset($_POST['pass'])) {

        echo $_POST['uname'] .$_POST['pass'];
        
        try {
            $security->verifyInputCredentials($_POST['uname'], $_POST['pass']);
        } catch (Exception $er) {
            echo "Error :" .$er->getMessage();
        }

    }
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['unameReg']) && isset($_POST['passReg'])) {
        echo $_POST['unameReg'] .$_POST['passReg'] ."<br>";
        // $security = new encryptionWork();
        $security->AddUsertoDatabase($_POST['unameReg'], $_POST['passReg']);
    }
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login authenticator</title>

</head>
<body>
    
    <form action='index1.php?login=1' method="post">
        <h3>Login</h3>
        <label for="username">username:</label>
        <input type="text" name="uname">

        <label for="pass">Password:</label>
        <input type="password" name="pass">
        <button type="submit">Login</button>
    </form>

    <form action="index1.php?login=0" method="post">
        <h3>Register</h3>

        <label for="uunameReg">username:</label>
        <input type="text" name="unameReg">

        <label for="passReg">Password:</label>
        <input type="password" name="passReg">

        <button type="submit">Register</button>
    </form>
</body>
</html>