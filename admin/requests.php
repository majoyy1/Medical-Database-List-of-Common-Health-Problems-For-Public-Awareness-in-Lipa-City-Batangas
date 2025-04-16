<?php
require_once "querys.php";
$temp = new CrudDisease();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['DeleteID'])) {

        if ($_POST['DeleteID'] == null){
            echo "Error NO DATA Inputed";
        } 
        else {
            echo $_POST['DeleteID'];
            $temp->deleteDiseaseData($_POST['DeleteID']);
            echo '--Send Request Success'; 
            header("Location: list.php?success=1");
        }

        // header("Location: list.php?success=1");
        exit;

    } else {
        echo "Error POST request!!";
    }
// -----------------Edit Request Data
    if (isset($_POST['EditID'])) {
        
    }
}

?>