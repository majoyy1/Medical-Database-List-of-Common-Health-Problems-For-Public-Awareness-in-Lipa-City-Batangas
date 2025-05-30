<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../logo.png" type="image/png">
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

    <link rel="stylesheet" href="css/list2.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment Data</title>
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
        <h3 class="title">Treatment Lists</h3>
    </div>

    <!-- Add Form -->
    <div class="formContainer">
        <form class="addForm" action="addTreatment.php" method="POST">
            <label for="TreatmentName">Treatment:</label>
            <button type="submit">Add Treatment</button>
        </form>
    </div>
    
    <table id="TreatmentTable" class="display-table">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Notes</th>
            <th>Actions</th>
        </thead>
    </table>

    <script>
    $(document).ready(function() {
        const table = $('#TreatmentTable').DataTable({
            order: [[0, 'asc']],
            ajax: {
                url: 'requests.php',
                method: 'GET',
                data: { request: 'Treatment' },
                dataSrc: 'dataTreatment'
            },
            columns: [
                { data: 'Treatment_ID', title: 'ID' },
                { data: 'Treatment_Name', title: 'Name' },
                { data: 'Description', title: 'Description' },
                { data: 'Notes', title: 'Notes' },
                {
                    data: null,
                    title: 'Actions',
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm edit-btn" data-id="${row.Treatment_ID}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${row.Treatment_ID}">Delete</button>
                        `;
                    }
                }
            ]
        });

        // Handle Edit Button Click
        $('#TreatmentTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            window.location.href = `editTreatment.php?editID=${id}`;
        });

        // Handle Delete Button Click
        $('#TreatmentTable').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this treatment?')) {
                window.location.href = `requests.php?DeletetrtID=${id}`;
            }
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
                window.location.href = 'treatmentList.php';
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
                window.location.href = 'treatmentList.php';
            });
        </script>";
    } elseif ($_GET['success'] == 2) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Treatment Modified Successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'treatmentList.php';
            });
        </script>";
    }
}
require_once '../loginStatus.php';
?>