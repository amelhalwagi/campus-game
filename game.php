<?php session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch user game state from database to ensure it's up-to-date
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT game_state FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($game_state);
$stmt->fetch();
$stmt->close();

// Update session with current game state
$_SESSION['game_state'] = $game_state;

// Define the game story and choices based on the game state
$story = "";
$choices = array();

switch($game_state) {
    case "start":
        $story = "You wake up on a foggy campus with no memory of how you got there. There's a mysterious note on your desk. What do you do?";
        $choices = array("read_note" => "Read the note", "explore_campus" => "Explore the campus");
        break;
    case "read_note":
        $story = "The note hints at a hidden secret in the library. Do you head to the library or ignore it?";
        $choices = array("go_library" => "Go to the library", "ignore_note" => "Ignore the note");
        break;
    case "explore_campus":
        $story = "While exploring, you find a strange key lying on the ground near a bench. What will you do?";
        $choices = array("pick_key" => "Pick up the key", "leave_key" => "Leave it and move on");
        break;
    case "go_library":
        $story = "At the library, you discover a secret passage behind a bookshelf!";
        $choices = array("enter_passage" => "Enter the passage", "go_back" => "Go back outside");
        break;
    // Add more states as needed for a richer adventure.
    default:
        $story = "Your adventure continues...";
        $choices = array("restart" => "Restart the game");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Campus Mystery Challenge - Game</title>
    <style>
        body { font-family: sans-serif; background-color: #e6f2ff; }
        .container { width: 600px; margin: 0 auto; background: #fff; padding: 20px; }
        .choice { margin: 10px 0; }
        button { padding: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Campus Mystery Challenge</h2>
    <p><?php echo $story; ?></p>
    <form method="post" action="process_choice.php">
        <?php foreach($choices as $value => $text): ?>
            <div class="choice">
                <button type="submit" name="choice" value="<?php echo $value; ?>"><?php echo $text; ?></button>
            </div>
        <?php endforeach; ?>
    </form>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
