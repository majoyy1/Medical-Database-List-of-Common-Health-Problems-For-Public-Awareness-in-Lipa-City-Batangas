<?php

require_once 'querys/symptoms.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_GET['requestSymptom']) && $_GET['requestSymptom'] == 1) {
        $symptoms = new CrudSymptoms();

        $symptomName = $symptoms->cleanData($_POST['symptomName']);
        $description = $symptoms->cleanData($_POST['description']);
        $severity = $symptoms->cleanData($_POST['severity']);
        $note = $symptoms->cleanData($_POST['note']);

        echo "<script>alert('Symptom Name: " . $symptomName . "');</script>";
        echo "<script>console.log('Description: " . $description . "');</script>";
        echo "<script>console.log('Severity: " . $severity . "');</script>";
        echo "<script>console.log('Note: " . $note . "');</script>";
        
            if ($symptoms->createData($symptomName, $description, $severity, $note)) {
                echo "<script>alert('Symptom added successfully!');</script>";
                // header("Location: addSympt.php?success=1");
                exit;
            } else {
                echo "<script>alert('Error adding symptom.');</script>";
            }
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Symptom</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add Symptom</h2>
        <form action="addSympt.php?requestSymptom=1" method="POST" onsubmit="return confirm('Are you sure to continue ADD Data?');">
            <label for="symptomName">Symptom Name:</label>
            <input type="text" id="symptomName" name="symptomName" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea><br><br>

            <label for="severity">Severity</label>
            <input type="text" id="severity" name="severity" require><br><br>

            <label for="note">Note:</label>
            <textarea id="note" name="note"></textarea><br><br>

            <button type="submit">Add Symptom</button>
            <button type="reset">Reset</button>
            <button type="button" onclick="window.location.href='list.php'">Back</button>
        </form>
    </div>
    
    
</body>
</html>