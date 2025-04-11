<?php
require_once 'dbConnection.php';

$DATA = new crud();
$result = $DATA->read();
header('Content-Type: application/json');
echo json_encode($result);
// var_dump($result);
?>
