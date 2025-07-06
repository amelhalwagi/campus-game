<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['choice'])) {
    $choice = $_POST['choice'];
    $current_state = $_SESSION['game_state'];

    // Determine next state based on current state and user choice
    $next_state = "";
    if ($current_state == "start") {
        if ($choice == "read_note") {
            $next_state = "read_note";
        } elseif ($choice == "explore_campus") {
            $next_state = "explore_campus";
        }
    } elseif ($current_state == "read_note") {
        if ($choice == "go_library") {
            $next_state = "go_library";
        } elseif ($choice == "ignore_note") {
            $next_state = "start"; // Loop back for simplicity
        }
    } elseif ($current_state == "explore_campus") {
        if ($choice == "pick_key") {
            $next_state = "read_note"; // Picking up the key reveals a note
        } elseif ($choice == "leave_key") {
            $next_state = "start";
        }
    } elseif ($current_state == "go_library") {
        if ($choice == "enter_passage") {
            $next_state = "secret_room";
        } elseif ($choice == "go_back") {
            $next_state = "start";
        }
    } else {
        if ($choice == "restart") {
            $next_state = "start";
        }
    }

    // If no valid transition, keep the same state
    if ($next_state == "") {
        $next_state = $current_state;
    }

    // Update game state in session and in the database
    $_SESSION['game_state'] = $next_state;
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("UPDATE users SET game_state = ? WHERE username = ?");
    $stmt->bind_param("ss", $next_state, $username);
    $stmt->execute();
    $stmt->close();

    header("Location: game.php");
    exit;
} else {
    header("Location: game.php");
    exit;
}
?>
