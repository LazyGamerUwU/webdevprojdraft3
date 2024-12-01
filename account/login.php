<?php
require '../classes/database.class.php';
require '../classes/authenticate.class.php';
require '../tools/functions.php';

// Instantiate Authenticator
$auth = new Authenticator($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    // Authenticate user
    if ($auth->login($username, $password)) {
        // Fetch user role
        $userRole = $auth->getUserRole($username); // Assuming `getUserRole` is a method that fetches the user's role

        // Redirect based on role
        if ($userRole === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($userRole === 'officer') {
            header("Location: ../officer/dashboard_officer.php");
        } else {
            header("Location: ../login.php?error=unauthorized"); // Redirect to login if role is unauthorized
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../includes/_head.php'; ?>
<title>OCESION - Login</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../style.css">
<style>
    body {
        background-color: #e8f5e9; /* Light green background */
        font-family: Arial, sans-serif;
        color: #2e7d32; /* Dark green text */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        background-color: #ffffff; /* White background for form */
        border: 1px solid #a5d6a7; /* Light green border */
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 400px;
        width: 100%;
    }
    h2 {
        color: #1b5e20; /* Deep green heading */
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group label {
        color: #2e7d32; /* Dark green for labels */
    }
    .form-control {
        border: 1px solid #a5d6a7; /* Light green border */
    }
    .btn-primary {
        background-color: #43a047; /* Medium green button */
        border-color: #43a047;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #388e3c; /* Darker green on hover */
    }
    .alert-danger {
        background-color: #ffcdd2; /* Light red for alert */
        color: #b71c1c; /* Dark red text */
        border: 1px solid #e57373;
    }
</style>
<body>
<div class="container">
    <h2>Log In</h2>
    <form method="POST">
        <div class="form-group mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
    </form>
    <a href="../index.php" class="btn btn-outline-primary w-100">Go Back</a>
</div>
</body>
</html>
