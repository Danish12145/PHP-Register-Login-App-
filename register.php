<?php
require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Register</h2>
    <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Username</label><input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label><input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label><input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-link">Login</a>
    </form>
</div>
</body>
</html>
