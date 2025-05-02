<?php
require_once 'querys/disease.php';
header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
//     echo json_encode(['error' => 'Invalid request method.'], JSON_PRETTY_PRINT);
//     exit;
// } 

$DATA = new CrudDisease();
$result = $DATA->read();
echo json_encode(['dataDisease' => $result], JSON_PRETTY_PRINT);


// $temp = new CrudCategory();
// $categoryResult = $temp->read();
// echo json_encode(['dataCategory' => $categoryResult], JSON_PRETTY_PRINT);
?>
