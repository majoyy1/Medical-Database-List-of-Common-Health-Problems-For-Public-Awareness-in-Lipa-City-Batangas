<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Treatment</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addSymptomForm.css">
</head>
<body>
    <div class="container">
        <h2>Add Treatment</h2>
        <form action="addTreatment.php?request=1" method="POST">
            <label for="treatmentName">Treatment Name:</label>
            <input type="text" id="treatmentName" name="treatmentName" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea><br><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note"></textarea><br><br>

            <button type="submit" class="btn btn-success">Add Treatment</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href=document.referrer">Back</button>
        </form>
    </div>
</body>
</html>

<?php
require_once 'querys/treatment.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['treatmentName'])) {
        $treatment = new CrudTreatment();

        $treatmentName = $treatment->cleanData($_POST['treatmentName']);
        $description = $treatment->cleanData($_POST['description']);
        $note = $treatment->cleanData($_POST['note']);

        if ($treatment->createTreatment($treatmentName, $description, $note)) {
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Treatment added successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'treatmentList.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to add treatment. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    }
}

require_once '../loginStatus.php';
?>
