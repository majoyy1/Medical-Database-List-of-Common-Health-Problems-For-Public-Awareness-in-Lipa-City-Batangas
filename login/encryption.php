<!-- this page is use to process the account verification -->

<?php
require_once 'authdb.php';

class encryptionWork {
    private $loginCrud;

    function __construct()
    {
        $this->loginCrud = new userCredentialCRUD();
    }
    
    private function encryptPassword($InputPassword){
        //Check if Whitespace and Convert Into Hashed
        try {
            if (!is_string($InputPassword) || trim($InputPassword) === '') {
                throw new Exception("Password cannot be empty or whitespace.L16<br>");
            } else {
                $temp = password_hash($InputPassword, PASSWORD_DEFAULT);

                if (password_verify($InputPassword, $temp)){
                    echo "Password is Correctly Encrypted" .": encryption.php L23 <br>";
                    return $temp;
                } else {
                    throw new Exception("Password Encryption Error");
                }
            }

            
        } catch (Exception $e){
            echo "Error: " .$e->getMessage();
        }
 
    }

    function verifyInputCredentials($uname, $InputPassword) {
        try {
            if (!is_string($uname) || trim($uname) === '' || !is_string($InputPassword) || trim($InputPassword)  === '') {
                throw new Exception("UserName or Password is Empty!!L62");
            } 
            $result = $this->loginCrud->SearchUserByUsername(htmlspecialchars($uname));

            if (!count($result) == 1){
                throw new Exception("Account Verification Failed");
            };

            // var_dump($result);
            // echo $result[0]["username"];
            // echo $result[0]["encryption"];

            $dbhashedpass = trim($result[0]["encryption"]);
            if (password_verify($InputPassword, $dbhashedpass)){
                echo "Password is Correct; <br>";
            } else {
                throw new Exception("Password Verification Error");
            }

        } catch (Exception $err) {
            echo "Error: " .$err->getMessage();
        }
    }

    function AddUsertoDatabase($uname, $passwordInput){
        try {
            if (!is_string($uname) || trim($uname) === '' || !is_string($passwordInput) || trim($passwordInput)  === '') {
                throw new Exception("UserName or Password is Empty!!L62");
            } 

            $result = $this->loginCrud->SearchUserByUsername($uname);

            if ($result == null){
                echo "Null <br>";

                $lockedpass = $this->encryptPassword($passwordInput);

                if ($this->loginCrud->AddUser($uname, $lockedpass)) {
                    echo "Password Stored In database->encrption.php L65<br>";
                    $this->verifyInputCredentials($uname, $passwordInput);
                } else {
                    throw new Exception("not store and not verified!!");
                }

            } else {
                throw new Exception("Already Have Username! Try Again.");
            }


        } catch (Exception $errrr) {
            echo 'Creating New Account Error: ' .$errrr->getMessage();
            
        }

    }

}

?>