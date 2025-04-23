
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disease Data</title>
</head>
<body>

    <table id="DiseaseTable" class="display" >
        <thead>
            <th>
                
            </th>
        </thead>
    </table>

    <!-- -----ADD FORM------------------------------------------------------->
    <form action="requests.php" method="post" onsubmit="return confirm('Delete this Data?');">
        <label for="DeleteID">ID:</label>
        <input type="text" id="DiName" name="DeleteID">
        <button type="submit" id=diName>DELETE</button>
    </form><br>
    <!-- ---------Edit Form------------- -->
    <form action="requests.php?usr=1" method="post">
        <label for="EditDataID">ID:</label>
        <input type="text" id="editdata" name="EditDataID">
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