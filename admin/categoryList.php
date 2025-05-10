<?php
session_start();
?>

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
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="css/list2.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Data</title>
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
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'symptoms.php' ? 'active' : '' ?>" href="symptoms.php">Symptoms</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'treatment.php' ? 'active' : '' ?>" href="treatment.php">Treatment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index1.php' ? 'active' : '' ?>" href="../login/index1.php?logout=1">Logout</a>
        </li>
    </ul>

    <div style="text-align: center;">
        <h3 class="title">Category Lists</h3>
    </div>
    <table id="CategoryTable" class="display-table">
        <thead>
            <th></th>
        </thead>
    </table>
    <!-- //addForm -->
    <div class="formContainer">
        <form class="addForm" action="requests.php?request=add" method="POST" onsubmit="return confirm('Are you sure to continue ADD Category?');">
            <label for="categname">Category:</label>
            <input type="text" id="categname" name="CategoryName" required><br><br>
            
            <label for="des">Description</label>
            <input type="text" id="des" name="Description" required><br><br>
            <button type="submit">Add Category</button>
        </form>

        <!-- Edit Form -->
        <form class="editForm" action="requests.php?request=edit" method="POST" onsubmit="return confirm('Are you sure to continue EDIT Category?');">
            <label for="editID">ID:</label>
            <input type="input" id="editdata" name="editID" required>

            <label for="editname">Category:</label>
            <input type="input" id="editname" name="CategoryName" required><br><br>

            <label for="description">Description</label>
            <input type="input" id="description" name="Description" required><br><br>

            <button type="submit">Edit</button>
        </form>

        <!-- Delete Form -->
        <form class="deleteForm" action="requests.php" method="GET" onsubmit="return confirm('Delete this Category?');">
            <label for="DeleteCatID">ID:</label>
            <input type="text" id="DeleteCatID" name="DeleteCatID">
            <button type="submit" id="DeleteCatID">DELETE</button>
        </form><br>
    </div>

    <script>
    $(document).ready(function() {
        const table = $('#CategoryTable').DataTable({
            order: [[0, 'asc']],
            ajax: {
                url: 'requests.php',
                method: 'GET',
                data: {request: 'category'},
                dataSrc: 'dataCategory'
            },
            columns: [
                { data: 'Category_ID', title: 'ID' },
                { data: 'Category_Name', title: 'Name' },
                { data: 'Description', title: 'Description' }
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
                window.location.href = 'categoryList.php';
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
                window.location.href = 'categoryList.php';
            });
        </script>";
    } elseif($_GET['success'] == 2) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Category Modified Successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'categoryList.php';
            });
        </script>";
    }
}
require_once '../loginStatus.php';
?>