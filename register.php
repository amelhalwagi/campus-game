<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        $error = "Please fill all fields.";
    } else {
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, game_state) VALUES (?, ?, ?)");
            $initial_state = "start"; // starting game state
            $stmt->bind_param("sss", $username, $hashed_password, $initial_state);
            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                $_SESSION['game_state'] = $initial_state;
                header("Location: game.php");
                exit;
            } else {
                $error = "Registration failed.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register - Campus Mystery Challenge</title>
</head>
<body>
<h2>Register</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post" action="register.php">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
<p><a href="index.php">Back to Home</a></p>
</body>
</html>

