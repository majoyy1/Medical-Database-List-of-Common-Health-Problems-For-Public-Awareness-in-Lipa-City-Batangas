<?php
require_once "querys/category.php";
require_once "querys/disease.php";
require_once "querys/treatment.php";
require_once 'querys/symptoms.php';

$distemp = new CrudDisease();
$categ = new CrudCategory();
$treatment = new CrudTreatment();
$symptom = new CrudSymptoms();

try {
    // Handle GET Requests
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch Treatment Data
        if (isset($_GET['request']) && $_GET['request'] === 'Treatment') {
            $result = $treatment->read();
            echo json_encode(['dataTreatment' => $result]);
            exit;
        }

        // Fetch Category Data
        if (isset($_GET['request']) && $_GET['request'] === 'category') {
            $categResult = $categ->read();
            echo json_encode(['dataCategory' => $categResult], JSON_PRETTY_PRINT);
            exit;
        }

        // Handle Delete Treatment
        if (isset($_GET['DeletetrtID'])) {
            $id = $treatment->cleanData($_GET['DeletetrtID']);
            if ($treatment->deleteTreatment($id)) {
                header("Location: TreatmentList.php?success=1");
            } else {
                throw new Exception("Error Deleting Treatment.");
            }
            exit;
        }

        // Handle Delete Symptom
        if (isset($_GET['DeleteSymptomID'])) {
            $id = $symptom->cleanData($_GET['DeleteSymptomID']);
            if ($symptom->deleteSymptomData($id)) {
                header("Location: symptomLists.php?success=1");
            } else {
                throw new Exception("Error Deleting Symptom.");
            }
            exit;
        }

        // Handle Delete Category
        if (isset($_GET['DeleteCatID'])) {
            $id = $categ->cleanData($_GET['DeleteCatID']);
            if ($categ->deleteCategory($id)) {
                header("Location: categoryList.php?success=1");
            } else {
                throw new Exception("Error Deleting Category.");
            }
            exit;
        }

        
    }

    // Handle POST Requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle Add Treatment
        if (isset($_GET['request']) && $_GET['request'] === 'addTreatment') {
            $name = $treatment->cleanData($_POST['TreatmentName']);
            $desc = $treatment->cleanData($_POST['Description']);
            if ($treatment->createTreatment($name, $desc, $note)) {
                header("Location: TreatmentList.php?success=1");
            } else {
                throw new Exception("Error Adding Treatment.");
            }
            exit;
        }


        // Handle Add Category
        if (isset($_GET['request']) && $_GET['request'] === 'addCategory') {
            $categoryName = $categ->cleanData($_POST['CategoryName']);
            $description = $categ->cleanData($_POST['Description']);
            if ($categ->createCategory($categoryName, $description)) {
                header("Location: categoryList.php?success=1");
            } else {
                throw new Exception("Error Adding Category.");
            }
            exit;
        }

        // Handle Edit Category
        if (isset($_GET['request']) && $_GET['request'] === 'editCategory') {
            $id = $categ->cleanData($_POST['editID']);
            $name = $categ->cleanData($_POST['CategoryName']);
            $description = $categ->cleanData($_POST['Description']);
            if ($categ->updateCategory($id, $name, $description)) {
                header("Location: categoryList.php?success=2");
            } else {
                throw new Exception("Error Editing Category.");
            }
            exit;
        }

        // Handle Delete Disease
        if (isset($_POST['DeleteID'])) {
            $check = $distemp->checkDataById($_POST['DeleteID']);
            if ($_POST['DeleteID'] == null) {
                throw new Exception("No ID Input.");
            } elseif (empty($check)) {
                throw new Exception("No matching ID found.");
            } else {
                $distemp->deleteDiseaseData($_POST['DeleteID']);
                header("Location: list.php?success=1");
                exit;
            }
        }
    }
} catch (Exception $e) {
    echo "<script>alert('Error: {$e->getMessage()}'); window.location.href = 'TreatmentList.php';</script>";
    exit;
}
?>