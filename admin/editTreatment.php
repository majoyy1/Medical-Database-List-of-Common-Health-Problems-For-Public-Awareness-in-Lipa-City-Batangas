<?php
session_start();

require_once "querys/treatment.php";

$treatments = new CrudTreatment();

$Data = [];

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['editID']) && !empty($_GET['editID'])) {
            $editID = $_GET['editID'];
            error_log("Received editID: $editID"); // Debugging output

            $temp = $treatments->checkTreatmentById($editID); // Corrected method name
            if (empty($temp)) {
                throw new Exception("1");
            }
            $Data = $temp[0];
        } else {
            throw new Exception("12");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['editID']) && !empty($_POST['editID'])) {
            $id = $treatments->cleanData($_POST['editID']);
            $Name = $treatments->cleanData($_POST['treatmentName']);
            $description = $treatments->cleanData($_POST['description']);
            $note = $treatments->cleanData($_POST['note']);

            $temp = $treatments->checkTreatmentById($id); // Corrected method name

            if (empty($temp)) {
                throw new Exception("2");
            }

            // Compare current data with updated data
            $currentData = [
                'treatment_name' => $temp[0]['treatment_name'],
                'Description' => $temp[0]['Description'],
                'Notes' => $temp[0]['Notes']
            ];

            $updatedData = [
                'treatment_name' => $Name,
                'Description' => $description,
                'Notes' => $note
            ];

            if ($currentData == $updatedData) {
                echo "<script>
                    alert('No changes were made.');
                    window.location.href = 'treatmentLists.php';
                </script>";
                exit;
            }

            if ($treatments->updateTreatment($Name, $description, $note, $id)) { // Adjusted arguments
                header("Location: treatmentLists.php?success=2");
                exit;
            } else {
                throw new Exception("Failed to update data.");
            }
        } else {
            throw new Exception("11");
        }
    }
} catch (Exception $err) {
    $msg = "Error Request! " . $err->getMessage() . " Try Again.";
    echo "<script>
    alert('$msg');
    window.location.href = 'list.php';
    </script>";
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
</head>
<body>
    <div class="container">
        <h2>Edit Treatment</h2>
        <form action="editTreatment.php" method="POST">
            <input type="hidden" value="<?= htmlspecialchars($_GET['editID']) ?>" name="ID">
            
            <label for="treatmentName">Treatment Name:</label>
            <input type="text" id="treatmentName" name="treatmentName" value="<?= htmlspecialchars($Data['treatment_name']) ?>" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= htmlspecialchars($Data['Description']) ?></textarea><br><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note"><?= htmlspecialchars($Data['Notes']) ?></textarea><br><br>

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
