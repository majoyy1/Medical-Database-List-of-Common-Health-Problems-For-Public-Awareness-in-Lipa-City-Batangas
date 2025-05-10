<?php

session_start();

require_once 'querys/disease.php';
require_once 'querys/category.php';
require_once 'querys/symptoms.php';
require_once 'querys/treatment.php';


$categ = new CrudCategory();
$categResult = $categ->read();

$symptoms = new CrudSymptoms();
$symptomsResult = $symptoms->read();

$treatment = new CrudTreatment();
$treatmentResult = $treatment->read();

$disease = new CrudDisease();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['DiName'])  && $_GET['request'] == 1) {
        
        $dName = $disease->cleanData($_POST['DiName']);
        $dDescription = $disease->cleanData($_POST['Description']);
        $dClasssif = $disease->cleanData($_POST['Classification']);
        $dCat = $disease->cleanData($_POST['Category']);
        $dNote = $disease->cleanData($_POST['Note']);
        $symp = $_POST['Symptoms'];
        $treat = $_POST['Treatment'];

        if ($disease->createData($dName, $dDescription, $dClasssif, $dCat, $dNote ?? '', $symp, $treat)) {
            $message = "The data has been added successfully!";
            header('Location: list.php?success=1');
            exit;
        } else {
            $message = "Error Adding Data";
            
            echo "<script>
            alert('$message');
            window.location.href = 'addForm.php';
            </script>";
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Disease</title>
    <link rel="stylesheet" href="css/addForm.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form action="addForm.php?request=1" method="post" class="edit-form">
        <h2>Add Disease Data</h2>
        <label for="Diname">Disease Name:</label>
        <input type="text" id="DiName" name="DiName" required><br><br>

        <label for="description">Description:</label>
        <textarea name="Description" id="description" required></textarea><br><br>
        
        <label for="classification">Classification</label>
        <input type="text" id="classification" name="Classification" required><br><br>

        <label for="category">Category:</label>
        <select id="category" name="Category">
            <?php
            if (count($categResult) > 0) {
                foreach ($categResult as $row) {
                    echo "<option value='" .$row["Category_ID"] . "'>" . $row["Category_Name"] ."</option>";
                }    
            } else {
                echo "<option value='NULL'>No Category In List</option>";
            };
            ?>
        </select><br><br>
        
        <!-- Multiple-select dropdown -->
        <label for="symptoms">Symptoms:</label>
        <select id="symptoms" name="Symptoms[]" multiple>
            <?php
            if (count($symptomsResult) > 0) {
                foreach ($symptomsResult as $row) {
                    echo "<option value='" . $row["Symptom_ID"] . "'>" . $row["Symptom_Name"] . "</option>";
                }
            } else {
                echo "<option value='NULL'>No Symptoms Available</option>";
            }
            ?>
        </select>
        <small>Hold Ctrl/Cmd to select multiple.</small><br>

        <button type="button" class="btn btn-secondary" onclick="window.location.href='addSymptom.php'">Add Symptom</button><br>
        
        <!-- Multiple-select dropdown -->
        <label for="treatment">Treatment:</label>
        <select id="treatment" name="Treatment[]" multiple>
            <?php
            if (count($treatmentResult) > 0) {
                foreach ($treatmentResult as $row) {
                    echo "<option value='" . $row["Treatment_ID"] . "'>" . $row["Treatment_Name"] . "</option>";
                }
            } else {
                echo "<option value='NULL'>No Treatment Available</option>";
            }
            ?>
        </select>
        <small>Hold Ctrl/Cmd to select multiple.</small><br>

        <button type="button" class="btn btn-secondary" onclick="window.location.href='addTreatment.php'">Add Treatment</button>


        <label for="Note">Note:</label>
        <textarea id="note" name="Note"></textarea><br><br>

        

        <button type="submit" name="addData">Submit</button>
        <button type="reset">Reset</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='list.php'">Back</button>

    </form>
    
    <script>
        $('form.edit-form').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit this form?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    this.submit();
                }
            });
        });
</script>

</body>

</html>

<?php

require_once '../loginStatus.php';


?>