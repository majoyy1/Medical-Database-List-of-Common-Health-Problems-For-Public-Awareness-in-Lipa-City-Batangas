<?php
require_once "querys/category.php";
require_once "querys/disease.php";
require_once "querys/treatment.php";

$distemp = new CrudDisease();
$categ = new CrudCategory();
$treats = new CrudTreatment();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle Delete Request
        if (isset($_POST['DeleteID']) ) {//DISEASE

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

        // Handle Add Category
        if (isset($_GET['request']) && $_GET['request'] === 'add') {
            $categoryName = $categ->cleanData($_POST['CategoryName']);
            $description = $categ->cleanData($_POST['Description']);

            if ($categ->createCategory($categoryName, $description)) {
                header("Location: categoryList.php?success=1");
            } else {
                throw new Exception("Error Adding Category.");
            }
        }

        // Handle Edit Category
        if (isset($_GET['request']) && $_GET['request'] === 'edit') {
            $id = $categ->cleanData($_POST['editID']);
            $name = $categ->cleanData($_POST['CategoryName']);
            $description = $categ->cleanData($_POST['Description']);

            if ($categ->updateCategory($id, $name, $description)) {
                header("Location: categoryList.php?success=2");
            } else {
                throw new Exception("Error Editing Category.");
            }
        }
    }

    // Handle GET Requests
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        if (isset($_GET['request']) && $_GET['request'] === 'category') {
            $categResult = $categ->read();
            echo json_encode(['dataCategory' => $categResult], JSON_PRETTY_PRINT);
        }elseif (isset($_GET['request']) && $_GET['request'] === 'Treatment') {
            $treatResult = $treats->read();
            echo json_encode(['dataTreatment' => $treatResult], JSON_PRETTY_PRINT);
        } 
            
        // Handle Delete Category
        if (isset($_GET['DeleteCatID']) ) {
            $id = $categ->cleanData($_GET['DeleteCatID']);

            if ($categ->deleteCategory($id)) {
                header("Location: categoryList.php?success=1");
            } else {
                throw new Exception("Error Deleting Category.");
            }
        }
    }

} catch (Exception $err) {
    $msg = "Error Request! " . $err->getMessage() . " Try Again.";
    echo "<script>
        alert('$msg');
        window.location.href = 'categoryList.php';
    </script>";
    exit;
}
?>