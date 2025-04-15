<?php
require_once 'authdb.php';

class encryptionWork {
    // private $userInput;
    // private $usernameInput;
    private $loginCrud;

    function __construct()
    {
        $this->loginCrud = new userCredentialCRUD();
    }
    
    private function encryptPassword($InputPassword){
        try {
            if (!is_string($InputPassword) || trim($InputPassword) === '') {
                throw new Exception("Password cannot be empty or whitespace.");
            }

            $temp = password_hash(trim($InputPassword), PASSWORD_DEFAULT);

            if (password_verify($InputPassword, $temp)){
                echo "Password is Correctly Encrypted";
            } else {
                throw new Exception("Password Encryption Error");
            }
        } catch (Exception $e){
            echo "Error: " .$e->getMessage();
        }
 
    }

    function verifyInputCredentials($uname, $InputPassword) {
        try {
            $result = $this->loginCrud->SearchUserByUsername(htmlspecialchars($uname));

            if (!count($result) == 1){
                throw new Exception("Account Verification Failed");
            };

            // var_dump($result);
            // echo $result[0]["username"];

            $hashedpass = trim($result[0]["encryption"]);
            if (password_verify($InputPassword, $hashedpass)){
                echo "Password is Correct;";
            } else {
                throw new Exception("Password Encryption Error");
            }

        } catch (Exception $err) {
            echo "Error: " .$err->getMessage();
        }
    }

    // function AddUsertoDatabase($uname, $passwordInput){
        
        
    //     $this->loginCrud->AddUser($uname, );

    // }

}

?>