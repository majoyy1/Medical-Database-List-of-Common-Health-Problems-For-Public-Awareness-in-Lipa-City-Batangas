<?php
session_start();
require_once "encryption.php";
$security = new encryptionWork();


// Handle logout first
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        
    $_SESSION = array();
    session_destroy();
    header("Location: index1.php");
    exit;
}

// Initialize loginstatus if not set
if (!isset($_SESSION['loginstatus'])) {
    $_SESSION['loginstatus'] = 0;
}

// Display any session messages
if (isset($_SESSION['registration_success'])) {
    echo '<script>
    Swal.fire({
        title: "Success!",
        text: "'.htmlspecialchars($_SESSION['registration_success']).'",
        icon: "success",
        confirmButtonText: "OK"
    });
    </script>';
    unset($_SESSION['registration_success']);
}

if (isset($_SESSION['registration_error'])) {
    echo '<script>
    Swal.fire({
        title: "Error!",
        text: "'.htmlspecialchars($_SESSION['registration_error']).'",
        icon: "error",
        confirmButtonText: "OK"
    });
    </script>';
    unset($_SESSION['registration_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Authenticator</title>
    <link rel="icon" href="../logo.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container py-3">
    <div class="d-flex justify-content-start">
        <a href="../index.php" class="btn btn-secondary">Home</a>
    </div>
</div>
    
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login</h3>
                    <form action="index1.php" method="post" id="loginForm">
                        <div class="mb-3">
                            <label for="uname" class="form-label">Username</label>
                            <input type="text" class="form-control" name="uname" maxlength="50" id="uname" placeholder="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label" placeholder="password">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass" maxlength="30" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Register Form Toggle Button -->
        <div class="text-center mb-3">
            <button type="button" class="btn btn-secondary" id="toggleRegisterForm">Register</button>
        </div>

        <!-- Register Form -->
        <div id="registerFormContainer" style="display: none;">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register</h3>
                    <form action="index1.php" method="post" id="registerForm">
                        <div class="mb-3">
                            <label for="unameReg" class="form-label">Username</label>
                            <input type="text" class="form-control" name="unameReg" maxlength="50" id="unameReg" required>
                        </div>
                        <div class="mb-3">
                            <label for="passReg" class="form-label">Password</label>
                            <input type="password" class="form-control" name="passReg" maxlength="30" id="passReg" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('toggleRegisterForm').addEventListener('click', function () {
        Swal.fire({
            title: 'Register',
            html: `
                <form action="index1.php" method="post" id="registerForm">
                    <div class="mb-3">
                        <label for="unameReg" class="form-label">Username</label>
                        <input type="text" class="form-control" name="unameReg" maxlength="50" id="unameReg" required>
                    </div>
                    <div class="mb-3">
                        <label for="passReg" class="form-label">Password</label>
                        <input type="password" class="form-control" name="passReg" maxlength="30" id="passReg" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Register</button>
                </form>
            `,
            showConfirmButton: false, 
            showCloseButton: true, 
            customClass: {
                popup: 'swal-wide' 
            }
        });
    });
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Login handler
    if (isset($_POST['uname']) && isset($_POST['pass'])) {
        try {
            if ($security->verifyInputCredentials($_POST['uname'], $_POST['pass'])) {
                $_SESSION['loginstatus'] = 1;                
                $_SESSION['username'] = htmlspecialchars($_POST['uname']);
                
                echo '<script>
                Swal.fire({
                    title: "Login Successful!",
                    text: "Welcome back, '.htmlspecialchars($_POST['uname']).'",
                    icon: "success",
                    confirmButtonText: "Continue"
                }).then(() => {
                    window.location.href = "../admin/list.php";
                });
                </script>';
                exit;
            } else {
                throw new Exception("Invalid username or password");
            }
        } catch (Exception $er) {
            echo '<script>
            Swal.fire({
                title: "Login Failed!",
                text: "'.htmlspecialchars($er->getMessage()).'",
                icon: "error",
                confirmButtonText: "Try Again"
            });
            </script>';
            exit;
        }
    }
    
    if (isset($_POST['unameReg']) && isset($_POST['passReg'])) {
        try {
            $username = trim($_POST['unameReg']);
            $password = trim($_POST['passReg']);
            
            if (empty($username) || empty($password)) {
                throw new Exception("Username and password cannot be empty");
            }
            
            $isSuccess = $security->AddUsertoDatabase($username, $password);
            
            if ($isSuccess === true) {
                $_SESSION['registration_success'] = "Registration successful! Please log in.";
                echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Registration successful! Please log in.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "index1.php";
                });
                </script>';
                exit;
            } else {
                throw new Exception($isSuccess);
            }
        } catch (Exception $er) {
            echo '<script>
            Swal.fire({
                title: "Registration Error!",
                text: "'.htmlspecialchars($er->getMessage()).'",
                icon: "error",
                confirmButtonText: "OK"
            });
            </script>';
            exit;
        }
    }
}
?>


</body>
</html>