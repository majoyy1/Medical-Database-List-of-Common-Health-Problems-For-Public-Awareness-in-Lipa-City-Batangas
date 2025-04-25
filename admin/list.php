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
        
</body>
<script>

</script>

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