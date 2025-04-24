<?php
require_once "querys.php";
$distemp = new CrudDisease();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['DeleteID'])) {
            
            $check = $distemp->checkDataById($_POST['DeleteID']);

            if ($_POST['DeleteID'] == null){
                throw new Exception("No ID Input.");
            } 
            elseif ($_POST['DeleteID'] != $check[0]['Disease_ID']){
                throw new Exception("No Matched ID Found.");
            }
            else {
                echo $_POST['DeleteID'];
                $distemp->deleteDiseaseData($_POST['DeleteID']);
                header("Location: list.php?success=1");
                exit;
            }
        }
        
    } 

    

} catch (Exception $err) {             
    $msg = "Error Request! " .$err->getMessage() ." Try Again.";
    echo "<script>
        alert('$msg');
        window.location.href = 'list.php';
        </script>";
}


?>