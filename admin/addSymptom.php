<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Symptom</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addSymptomForm.css">
</head>
<body>
    <div class="container">
        <h2>Add Symptom</h2>
        <form action="addSymptom.php?request=1" method="POST">
            <label for="symptomName">Symptom Name:</label>
            <input type="text" id="symptomName" name="symptomName" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea><br><br>

            <label for="severity">Severity:</label>
            <input type="text" id="severity" name="severity" required><br><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note"></textarea><br><br>

            <button type="submit" class="btn btn-success">Add Symptom</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='addForm.php'">Back</button>
        </form>
    </div>
</body>
</html>

<?php

require_once 'querys/symptoms.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['symptomName'])) {
        $symptoms = new CrudSymptoms();

        $symptomName = $symptoms->cleanData($_POST['symptomName']);
        $description = $symptoms->cleanData($_POST['description']);
        $severity = $symptoms->cleanData($_POST['severity']);
        $note = $symptoms->cleanData($_POST['note']);

        if ($symptoms->createData($symptomName, $description, $severity, $note)) {
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Symptom added successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'addForm.php'; // Redirect to the addForm page
                });
            </script>";
        } else {
            // Error response
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to add symptom. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
}

?>
