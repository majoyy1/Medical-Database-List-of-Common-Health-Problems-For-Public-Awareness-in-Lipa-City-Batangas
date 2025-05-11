<?php
session_start();

require_once "querys/symptoms.php";

$symptoms = new CrudSymptoms();

$Data = [];

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['editID']) && !empty($_GET['editID'])) {
            $temp = $symptoms->checkDataById($_GET['editID']);
            if (empty($temp)) {
                throw new Exception("No data found for the given ID.");
            }
            $Data = $temp[0];
        } else {
            throw new Exception("Invalid or missing ID.");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['ID']) && !empty($_POST['ID'])) {
            $id = $symptoms->cleanData($_POST['ID']);
            $Name = $symptoms->cleanData($_POST['symptomName']);
            $description = $symptoms->cleanData($_POST['description']);
            $severity = $symptoms->cleanData($_POST['severity']);
            $note = $symptoms->cleanData($_POST['note']);


            $temp = $symptoms->checkDataById($id);

            if (empty($temp)) {
                throw new Exception("No data found for the given ID.");
            }

            $currentData = [
                'Symptom_Name' => $temp[0]['Symptom_Name'],
                'Description' => $temp[0]['Description'],
                'Severity' => $temp[0]['Severity'],
                'Note' => $temp[0]['Note']
            ];

            $updatedData = [
                'Symptom_Name' => $Name,
                'Description' => $description,
                'Severity' => $severity,
                'Note' => $note
            ];

            if ($currentData == $updatedData) {
                echo "<script>
                    alert('No changes were made.');
                    window.location.href = 'symptomLists.php';
                </script>";
                exit;
            }

            if ($symptoms->updateSymptom($id, $Name, $description, $severity, $note)) {
                header("Location: symptomLists.php?success=2");
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
    window.location.href = 'list.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Symptom</title>
    <link rel="icon" href="../logo.png" type="image/png">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addSymptomForm.css">
</head>
<body>
    <div class="container">
        <h2>Edit Symptom</h2>
        <form action="editSymptom.php" method="POST">
            <input type="hidden" value="<?= htmlspecialchars($_GET['editID']) ?>" name="ID">
            <label for="symptomName">Symptom Name:</label>
            <input type="text" id="symptomName" maxlength="50" name="symptomName" value="<?= htmlspecialchars($Data['Symptom_Name']) ?>" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= htmlspecialchars($Data['Description']) ?></textarea><br><br>

            <label for="severity">Severity:</label>
            <input type="text" id="severity" name="severity" maxlength="30" value="<?= htmlspecialchars($Data['Severity']) ?>" required><br><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note"><?= htmlspecialchars($Data['Note']) ?></textarea><br><br>

            <button type="submit" class="btn btn-success">Update Symptom</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href=document.referrer">Back</button>
        </form>
    </div>
</body>
</html>

<?php
require_once '../loginStatus.php';
?>
