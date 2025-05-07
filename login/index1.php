<?php
require_once "encryption.php";
$security = new encryptionWork();

$loginSuccess = false;
$registerSuccess = false;
$errorMsg = "";

//Login Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['uname']) && isset($_POST['pass'])) {
        
        try {
            if ( $security->verifyInputCredentials($_POST['uname'], $_POST['pass'])){
                echo "Login Success! <br>";
                $loginSuccess = true;
                $_SESSION['username'] = htmlspecialchars($_POST['uname']);
            } else {
                throw new Exception("Login Failed!");
            }
           
        } catch (Exception $er) {
            $errorMsg = $er->getMessage();
        }
    }

    if (isset($_POST['unameReg']) && isset($_POST['passReg'])) {
        try {
            $security->AddUsertoDatabase($_POST['unameReg'], $_POST['passReg']);
            $registerSuccess = true;
        } catch (Exception $er) {
            $errorMsg = $er->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Authenticator</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Login Form -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login</h3>
                    <form action="index1.php" method="post">
                        <div class="mb-3">
                            <label for="uname" class="form-label">Username</label>
                            <input type="text" class="form-control" name="uname" id="uname" placeholder="usename" required>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Register Form -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register</h3>
                    <form action="index1.php" method="post">
                        <div class="mb-3">
                            <label for="unameReg" class="form-label">Username</label>
                            <input type="text" class="form-control" name="unameReg" id="unameReg" required>
                        </div>
                        <div class="mb-3">
                            <label for="passReg" class="form-label">Password</label>
                            <input type="password" class="form-control" name="passReg" id="passReg" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($loginSuccess): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Login Successful!',
    text: "Hello, <?= htmlspecialchars($_SESSION['username']) ?>",
    confirmButtonColor: '#3085d6'
}).then(() => {
                window.location.href = '../admin/list.php';
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

</body>
</html>
