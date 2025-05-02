<!DOCTYPE html>
<html lang="en">
<head>
    <!--DataTables CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <!--jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!--DataTables JS-->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <!-- Bootstrap CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ---sweealert js---- -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

    <link rel="stylesheet" href="css/list.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease Data</title>
</head>
<body>
    <div style="text-align: center;">
        <h3 class="title">Health Lists</h3>
    </div>
    <table id="DiseaseTable" class="display-table" >
        
        <thead>
            <th>
                
            </th>
        </thead>
    </table>

    <!-- -----Delete FORM------------------------------------------------------->
    <form action="requests.php" method="post" onsubmit="return confirm('Delete this Data?');">
        <label for="DeleteID">ID:</label>
        <input type="text" id="DiName" name="DeleteID">
        <button type="submit" id=diName>DELETE</button>
    </form><br>

    <form action="addForm.php" method="get" class="add-data-form">
        <button>Add Data</button>
    </form>
    <!-- ---------Edit Form------------- -->
    <form action="edit.php" method="GET" onsubmit="return confirm('Are you sure to continue EDIT Data?');">
        <label for="editID">ID:</label>
        <input type="text" id="editdata" name="editID">
        <input type="text" id="idver" name="auth" value="1" hidden>
        <button type="submit">Edit</button>
    </form>

        <!-- Bootstrap Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Disease Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="modalDiseaseID"></span></p>
                    <p><strong>Name:</strong> <span id="modalDiseaseName"></span></p>
                    <p><strong>Description:</strong> <span id="modalDescription"></span></p>
                    <p><strong>Classification:</strong> <span id="modalClassification"></span></p>
                    <p><strong>Category:</strong> <span id="modalCategory"></span></p>
                    <p><strong>Additional Info:</strong> <span id="modalAdditionalInfo"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


        
</body>
<script>

</script>

<script>
    $(document).ready(function() {
        const table = $('#DiseaseTable').DataTable({
            order: [[1, 'asc']],
            ajax: {
                url: 'callData.php',
                dataSrc: 'dataDisease'
            },
            columns: [
                { data: 'Disease_ID', title: 'ID' },
                { data: 'Disease_Name', title: 'Name' },
                { data: 'Description', title: 'Description' },
                { data: 'Classification', title: 'Classification' },
                { data: 'Category_Name', title: 'Category' }
            ]
        });

        // Add click event to rows
        $('#DiseaseTable tbody').on('click', 'tr', function() {
            const data = table.row(this).data(); // Get the data for the clicked row
            if (data) {
                // Fetch additional details using AJAX
                $.ajax({
                    url: 'getDetails.php', // Endpoint to fetch additional details
                    method: 'POST', // Use POST to send the ID
                    data: { id: data.Disease_ID }, // Send the Disease_ID as 'id'
                    success: function(response) {
                        console.log(response); // Debug: Log the response to verify the structure

                        if (response.error) {
                            Swal.fire({
                                title: 'Error!',
                                text: response.error,
                                icon: 'error'
                            });
                        } else if (response.length > 0) {
                            // Access the first element of the array
                            const data = response[0];

                            // Populate the modal with the fetched data
                            $('#modalDiseaseID').text(data.Disease_ID || 'N/A');
                            $('#modalDiseaseName').text(data.Disease_Name || 'N/A');
                            $('#modalDescription').text(data.Description || 'N/A');
                            $('#modalClassification').text(data.Classification || 'N/A');
                            $('#modalCategory').text(data.Category_ID || 'N/A');
                            $('#modalAdditionalInfo').text(data.Note || 'N/A');

                            // Show the modal
                            $('#detailsModal').modal('show');
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'No data found.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to fetch details.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

</script>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['success'])) {
    if ($_GET['success'] == 1) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Request Successfull!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'list.php';
            });
        </script>";
    } elseif (isset($_GET['error'])) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Request Failed.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    } elseif($_GET['success'] == 2) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Data Modified Successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>

