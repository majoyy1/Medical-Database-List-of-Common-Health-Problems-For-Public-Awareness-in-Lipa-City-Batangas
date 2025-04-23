<?php
require_once "querys.php";
$temp = new CrudDisease();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['DeleteID'])) {
    
            if ($_POST['DeleteID'] == null){
                throw new Exception("No ID Input.");
            } 
            else {
                echo $_POST['DeleteID'];
                $temp->deleteDiseaseData($_POST['DeleteID']);
                echo '--Send Request Success'; 
                header("Location: list.php?success=1");
                exit;
            }
        }

    } else {
        throw new Exception("Error Sending Requests! Contact Admin.");
    }
} catch (Exception $err) {             
    $msg = "Error Request! " .$err->getMessage() ." Try Again.";
    echo "<script>
        alert('$msg');
        window.location.href = 'list.php';
        </script>";
}


?>