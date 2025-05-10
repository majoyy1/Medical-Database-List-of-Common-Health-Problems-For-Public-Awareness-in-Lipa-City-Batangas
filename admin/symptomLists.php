<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <!-- Bootstrap CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../logo.png" type="image/png">

    <link rel="stylesheet" href="css/list2.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptoms Data</title>
</head>
<body>
    <!-- Bootstrap Nav-Pills -->
    <ul class="nav nav-pills justify-content-center bg-light py-3">
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'categoryList.php' ? 'active' : '' ?>" href="categoryList.php">Category</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'list.php' ? 'active' : '' ?>" href="list.php">Diseases</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'symptomLists.php' ? 'active' : '' ?>" href="symptomLists.php">Symptoms</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'treatmentList.php' ? 'active' : '' ?>" href="treatmentList.php">Treatment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index1.php' ? 'active' : '' ?>" href="../login/index1.php?logout=1">Logout</a>
        </li>
    </ul>

    <div style="text-align: center;">
        <h3 class="title">Symptom Lists</h3>
        <!-- Add Symptom Button -->
        <a href="addSymptom.php" class="btn btn-success mb-3">Add Symptom</a>
    </div>
    <table id="SymptomTable" class="display-table">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Severity</th>
            <th>Note</th>
            <th>Date Added</th>
            <th>Actions</th>
        </thead>
    </table>

    <script>
    $(document).ready(function() {
        const table = $('#SymptomTable').DataTable({
            order: [[0, 'asc']],
            ajax: {
                url: 'callData.php',
                method: 'GET',
                data: { request: 'symptom' },
                dataSrc: 'dataSymptom'
            },
            columns: [
                { data: 'Symptom_ID', title: 'ID' },
                { data: 'Symptom_Name', title: 'Name' },
                { data: 'Description', title: 'Description' },
                { data: 'Severity', title: 'Severity' },
                { data: 'Note', title: 'Note' },
                { data: 'DateCreated', title: 'Date Added' },
                {
                    data: null,
                    title: 'Actions',
                    render: function(data, type, row) {
                        return `
                            <form class="editForm" action="editSymptom.php" method="GET" style="display:inline;">
                                <input type="hidden" name="editID" value="${row.Symptom_ID}">
                                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                            </form>
                            <form class="deleteForm" action="requests.php" method="GET" style="display:inline;" onsubmit="return confirm('Delete this Symptom?');">
                                <input type="hidden" name="DeleteSymptomID" value="${row.Symptom_ID}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        `;
                    }
                }
            ]
        });
    });
    </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['success'])) {
    if ($_GET['success'] == 1) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Request Successful!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'symptomLists.php';
            });
        </script>";
    } elseif (isset($_GET['error'])) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Request Failed.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'symptomLists.php';
            });
        </script>";
    } elseif ($_GET['success'] == 2) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Symptom Modified Successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'symptomLists.php';
            });
        </script>";
    }
}
require_once '../loginStatus.php';
?>