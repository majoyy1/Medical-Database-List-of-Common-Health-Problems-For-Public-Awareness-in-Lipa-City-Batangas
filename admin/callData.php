<?php
require_once 'querys/disease.php';
require_once 'querys/symptoms.php';
require_once 'querys/treatment.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['request']) && $_POST['request'] == 1) {
            $DATA = new CrudDisease();
            $result = $DATA->read();
            echo json_encode(['dataDisease' => $result], JSON_PRETTY_PRINT);    
        }   
        elseif ($_POST['request'] == 2 && isset($_POST['id'])) {
            $DATA = new CrudDisease();
            $symptoms = new CrudSymptoms();

            $result = $DATA->checkDataById($_POST['id']);
            $symptomsData = $symptoms->checkSymptomOfId($_POST['id']);
            
            echo json_encode(['dataDisease' => $result, 'symptomsData' => $symptomsData], JSON_PRETTY_PRINT);
            
        } 
        // elseif (){
        //     $trate = new CrudTreatment();
        //     $results = $trate->read();
        //     echo json_encode(['treatmentlist' => $result], JSON_PRETTY_PRINT);  

        // }
        else {
            echo json_encode(['error' => 'Error requesting Data.']);
        }
        
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
    exit;
}

?>
