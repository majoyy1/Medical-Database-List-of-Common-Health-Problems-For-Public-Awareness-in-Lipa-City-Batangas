<?php

// Handle logout
if (isset($_GET['logout'])) {
    header("Location: index1.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS & SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MyWebsite</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <?php if (($_SESSION['loginSuccess']) == true): ?>
                    <li class="nav-item">
                        <span class="nav-link">Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="index1.php?logout=1">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-light ms-2" href="login/index1.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- SweetAlert Feedback -->
<?php if ($loginSuccess): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Login Successful!',
    text: 'Welcome back!',
    confirmButtonColor: '#3085d6'
});
</script>
<?php elseif ($registerSuccess): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Registration Successful!',
    text: 'You can now log in.',
    confirmButtonColor: '#28a745'
});
</script>
<?php elseif (!empty($errorMsg)): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: <?= json_encode($errorMsg) ?>,
    confirmButtonColor: '#dc3545'
});
</script>
<?php endif; ?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
