<?php
require_once "querys.php";
$temp = new CrudDisease();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['DeleteID'])) {
    echo $_POST['DeleteID'];
    $temp->deleteDiseaseData($_POST['DeleteID']);
    echo 'Send Request Success'; 
    } else {
        echo "Error request!!";
    }
// -----------------Edit Request Data
    if (isset($_POST['EditID'])) {

    }
}

?>