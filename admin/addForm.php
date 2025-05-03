<?php
require_once 'querys/disease.php';
require_once 'querys/category.php';
require_once 'querys/symptoms.php';

$categ = new CrudCategory();
$categResult = $categ->read();

$symptoms = new CrudSymptoms();
$symptomsResult = $symptoms->read();

$disease = new CrudDisease();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['DiName'])  && $_GET['request'] == 1) {
        
        echo "<script>
        console.log(" . $_POST['DiName'] . ");
        console.log(" . $_POST['Description'] . ");
        console.log(" . $_POST['Classification'] . ");
        console.log(" . $_POST['Category'] . ");
        console.log(" . $_POST['Note'] . ");
        console.log(" . $_POST['Symptoms'] . ");
            </script>";

        $dName = $disease->cleanData($_POST['DiName']);
        $dDescription = $disease->cleanData($_POST['Description']);
        $dClasssif = $disease->cleanData($_POST['Classification']);
        $dCat = $disease->cleanData($_POST['Category']);
        $dNote = $disease->cleanData($_POST['Note']);
        $symp = $_POST['Symptoms'];
        
        if ($disease->createData($dName, $dDescription, $dClasssif, $dCat, $dNote, $symp)) {
            $message = "The data has been added successfully!";

            echo "<script>
            alert('$message');
            window.location.href = 'list.php?success=1';
            </script>";
        } else {
            $message = "Error Adding Data";
            $redirect_url = "addForm.php";

            echo "<script>
            alert('$message');
            window.location.href = '';
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
        <small>Hold Ctrl/Cmd to select multiple.</small><br><br>

        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSymptomModal">
            Add Symptom
        </button>

        <!-- Display added symptoms -->
        <div id="addedSymptoms" style="margin-top: 15px;">
            <h5>Added Symptoms:</h5>
            <ul id="symptomList"></ul>
        </div><br>
        
        <label for="Note">Note:</label>
        <textarea id="note" name="Note"></textarea><br><br>

        <button type="submit" name="addData">Submit</button>
        <button type="reset">Reset</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='list.php'">Back</button>

    </form>
    <form action="">
        
        <!-- Modal for adding symptoms -->
        <div class="modal fade" id="addSymptomModal" tabindex="-1" aria-labelledby="addSymptomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"> <!-- Center the modal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSymptomModalLabel">Add Symptom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="newSymptom" class="form-label">Symptom Name:</label>
                        <input type="text" id="newSymptom" class="form-control" placeholder="Enter symptom name">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="saveSymptom">Save Symptom</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
a
    
    
    <script>
        $(document).ready(function () {
            // Handle adding a new symptom
            $('#saveSymptom').on('click', function () {
                const newSymptom = $('#newSymptom').val().trim();
                if (newSymptom) {
                    // Add the symptom to the list
                    $('#symptomList').append('<li>' + newSymptom + '</li>');

                    // Optionally, add it to the dropdown
                    $('#symptoms').append('<option value="' + newSymptom + '">' + newSymptom + '</option>');

                    // Clear the input and close the modal
                    $('#newSymptom').val('');
                    $('#addSymptomModal').modal('hide');
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter a symptom name.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

    $(document).ready(function () {
        // Handle adding a new symptom
        $('#saveSymptom').on('click', function () {
            const newSymptom = $('#newSymptom').val().trim();
            if (newSymptom) {
                // Add the symptom to the list
                $('#symptomList').append('<li>' + newSymptom + '</li>');

                // Optionally, add it to the dropdown
                $('#symptoms').append('<option value="' + newSymptom + '">' + newSymptom + '</option>');

                // Clear the input and close the modal
                $('#newSymptom').val('');
                $('#addSymptomModal').modal('hide');
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter a symptom name.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });

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
    });
</script>

</body>

</html>