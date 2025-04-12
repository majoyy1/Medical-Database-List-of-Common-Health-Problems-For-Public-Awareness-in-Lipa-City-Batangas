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
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease Data</title>
</head>
<body>
        <!-- Button to Open Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
        Open Form
    </button>

    <!-- ---------------------------------------------------------- -->
    <!-- <button type="submit" value="hahah">Add Data</button> -->

    <!-- <form action="admin/callData.php">
        <input type="submit" value="Add Disease"/>
        </form> -->
    <table id="DiseaseTable" class="display" >
        <thead>
            <th>
                
            </th>
        </thead>
    </table>

    <!-- -----ADD FORM------------------------------------------------------->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
</body>

<script>
    $(document).ready(function() {
        
        $('#DiseaseTable').DataTable({
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
    });
</script>

</html>