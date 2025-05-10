<?php
session_start();

require_once "querys/treatment.php";

$treatments = new CrudTreatment();

$Data = [];

try {
    // Handle GET request to fetch treatment data for editing
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['editID'])) {
            $editID = $treatments->cleanData($_GET['editID']);
            $temp = $treatments->checkTreatmentById($editID);

            if (empty($temp)) {
                throw new Exception("No data found for the given ID.");
            }

            $Data = $temp[0];
        } else {
            throw new Exception("Invalid or missing ID.");
        }
    }

    // Handle POST request to update treatment data
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request']) && $_POST['request'] === 'edit') {
        if (isset($_POST['ID']) && !empty($_POST['ID'])) {
            $id = $treatments->cleanData($_POST['ID']);
            $Name = $treatments->cleanData($_POST['treatmentName']);
            $description = $treatments->cleanData($_POST['description']);
            $note = $treatments->cleanData($_POST['note']);

            $temp = $treatments->checkTreatmentById($id);

            if (empty($temp)) {
                throw new Exception("No data found for the given ID.");
            }

            // Update the treatment if there are changes
            if ($treatments->updateTreatment($Name, $description, $note, $id)) {
                header("Location: treatmentList.php?success=2");
                exit;
            } else {
                throw new Exception("Failed to update data.");
            }
        } else {
            throw new Exception("Invalid or missing ID.");
        }
    }
} catch (Exception $err) {
    $msg = "Error Request! " . $err->getMessage() . " Try Again.";
    echo "<script>
    alert('$msg');
    window.location.href = 'treatmentList.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Treatment</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addSymptomForm.css">
    <link rel="icon" href="../logo.png" type="image/png">
</head>
<body>
    <div class="container">
        <h2>Edit Treatment</h2>
        
        <form action="editTreatment.php" method="POST">
            <input type="hidden" value="<?= htmlspecialchars($Data['Treatment_ID'] ?? '') ?>" name="ID">
            <input type="hidden" value="edit" name="request">
            
            <label for="treatmentName">Treatment Name:</label>
            <input type="text" id="treatmentName" name="treatmentName" value="<?= htmlspecialchars($Data['Treatment_Name'] ?? '') ?>" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= htmlspecialchars($Data['Description'] ?? '') ?></textarea><br><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note"><?= htmlspecialchars($Data['Notes'] ?? '') ?></textarea><br><br>
            <textarea name="" id=""><?= var_dump($Data) ?></textarea>
            <button type="submit" class="btn btn-success">Update Treatment</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href=document.referrer">Back</button>
        </form>
    </div>
</body>
</html>

<?php
require_once '../loginStatus.php';
?>
