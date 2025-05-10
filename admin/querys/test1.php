<?php
require_once 'disease.php';
require_once 'category.php';
$disease = new CrudDisease();
$result = $disease->getCreatedID();
// var_dump($result); // Debugging line to check the output
$diseaseID = 40;
$symptomID = 1;

$stmt = $disease->db->prepare("CALL AddDiseaseSymptom(:diseaseID, :symptomID);");
$stmt->execute([':diseaseID' => $diseaseID,':symptomID' => $symptomID]);


?>