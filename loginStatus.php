<?php
require_once 'login/encryption.php';
echo $_SESSION['loginstatus'];


if ($_SESSION['loginstatus'] == 0 || $_SESSION['loginstatus'] == null) {
    echo '
    <script>
    Swal.fire({
        title: "Login Required",
        text: "You need to login first to access this page.",
        icon: "warning",
        confirmButtonText: "OK",
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../login/index1.php";
        }
    });
    </script>
    ';
    exit();
}





?>