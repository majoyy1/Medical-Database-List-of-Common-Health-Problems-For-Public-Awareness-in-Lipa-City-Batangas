<?php
require_once 'querys/disease.php';
require_once 'querys/symptoms.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['request']) && $_POST['request'] == 1) {
            $DATA = new CrudDisease();
            $result = $DATA->read();
            echo json_encode(['dataDisease' => $result], JSON_PRETTY_PRINT);    
        } elseif ($_POST['request'] == 2 && isset($_POST['id'])) {
            $DATA = new CrudDisease();
            $symptoms = new CrudSymptoms();

            $result = $DATA->checkDataById($_POST['id']);
            $symptomsData = $symptoms->checkSymptomOfId($_POST['id']);
            
            echo json_encode(['dataDisease' => $result, 'symptomsData' => $symptomsData], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['error' => 'Error requesting Data.']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['request']) && $_GET['request'] == 'symptom') {
            $symptom = new CrudSymptoms();
            $dataSymptom = $symptom->read();
            echo json_encode(['dataSymptom' => $dataSymptom], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['error' => 'Invalid GET request.']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
    exit;
}
?>
