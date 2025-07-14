<?php
require_once "includes/db.php";
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "No account found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if ($message) echo "<div class='alert alert-danger'>$message</div>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Email</label><input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label><input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success">Login</button>
        <a href="register.php" class="btn btn-link">Register</a>
    </form>
</div>
</body>
</html>
