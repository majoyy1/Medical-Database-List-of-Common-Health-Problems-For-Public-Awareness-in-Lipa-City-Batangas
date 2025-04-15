<?php
require_once 'querys.php';
header('Content-Type: application/json');

$DATA = new CrudDisease();
$result = $DATA->read();
echo json_encode(['dataDisease' => $result], JSON_PRETTY_PRINT);

// var_dump($result);

// $temp = new CrudCategory();
// $categoryResult = $temp->read();
// echo json_encode(['dataCategory' => $categoryResult], JSON_PRETTY_PRINT);
?>
