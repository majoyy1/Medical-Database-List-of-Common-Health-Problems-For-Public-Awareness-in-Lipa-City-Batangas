<?php
require_once 'querys/disease.php';
header('Content-Type: application/json');

if (isset($_POST['id'])) { // Use $_POST to access the 'id' sent via POST
    $DATA = new CrudDisease();
    $result = $DATA->checkDataById($_POST['id']); // Fetch details using the provided ID
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'No ID provided.']);
}
?>