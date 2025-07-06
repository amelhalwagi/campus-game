<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Campus Mystery Challenge</title>
    <style>
        body { font-family: sans-serif; background-color: #f2f2f2; }
        .container { width: 600px; margin: 0 auto; background: #fff; padding: 20px; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome to Campus Mystery Challenge!</h1>
    <?php if(isset($_SESSION['username'])): ?>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <p><a href="game.php">Continue your adventure</a></p>
        <p><a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to start your adventure.</p>
    <?php endif; ?>
</div>
</body>
</html>

