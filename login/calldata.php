<?php

require_once 'loginCrud.php';
header('Content-Type: application/json');

$temp = new userCredentialCRUD();
$result = $temp->checkAllUser();
echo json_encode($result, JSON_PRETTY_PRINT);


?>