<?php
require_once 'authdb.php';

class encryptionWork {
    private $loginCrud;

    function __construct(){
        $this->loginCrud = new userCredentialCRUD();
    }
    
    private function encryptPassword($InputPassword){
        try {
            if (!is_string($InputPassword) || trim($InputPassword) === '') {
                throw new Exception("Password cannot be empty or whitespace.L16<br>");
            } else {
                $temp = password_hash($InputPassword, PASSWORD_DEFAULT);

                if (password_verify($InputPassword, $temp)){
                    // echo "Password is Correctly Encrypted" .": encryption.php L23 <br>";
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
                // echo "Password is Correct; <br>";
                return true;
            } else {
                throw new Exception("Password Verification Error");
            }

        } catch (Exception $err) {
            echo "Error: " .$err->getMessage();
            return false;
        }
    }

    function AddUsertoDatabase($uname, $passwordInput) {
        try {
            // Validate input parameters
            if (!is_string($uname) || trim($uname) === '' || 
                !is_string($passwordInput) || trim($passwordInput) === '') {
                throw new Exception("Username or Password cannot be empty");
            }
    
            // Check if username already exists
            $existingUser = $this->loginCrud->SearchUserByUsername($uname);
            if ($existingUser) {
                throw new Exception("Username already exists. Please choose a different username.");
            }
                
            // Encrypt password and add user
            $lockedpass = $this->encryptPassword($passwordInput);
            
            if (!$this->loginCrud->AddUser($uname, $lockedpass)) {
                throw new Exception("Failed to store user in database");
            }
    
            // Verify the newly created credentials
            if (!$this->verifyInputCredentials($uname, $passwordInput)) {
                throw new Exception("Account created but verification failed");
            }
    
            return true;
    
        } catch (Exception $e) {
            error_log("AddUsertoDatabase Error: " . $e->getMessage());
            return $e->getMessage();
        }
    }

}

?>