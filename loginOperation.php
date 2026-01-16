<?php
$route = $_REQUEST['url'];
$route();

function login() {
    include 'Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email) {
        echo json_encode(["status" => "error", "message" => 'Username or Email is required']);
        return;
    }
    if (!$password) {
        echo json_encode(["status" => "error", "message" => 'Password is required']);
        return;
    }

    // ---------- 1. Check in users table (username only) ----------
    $queryUser = 'SELECT * FROM users WHERE username = :username AND status = "active"';
    $stmUser = $conn->prepare($queryUser);
    $stmUser->execute(['username' => $email]);
    $userData = $stmUser->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        if ($password == $userData['password']) {
            session_start();
            $_SESSION['user'] = $userData['username'];
            $_SESSION['user_id'] = $userData['user_id'];
            $_SESSION['role'] = $userData['role'];
            $_SESSION['email'] = null;

            echo json_encode([
                "status" => "success",
                "message" => 'User logged in successfully',
                "role" => $userData['role']
            ]);
            return;
        } else {
            echo json_encode(["status" => "error", "message" => 'Incorrect password']);
            return;
        }
    }

    // ---------- 2. Check in passengers table (email) ----------
    $queryPassenger = 'SELECT * FROM passengers WHERE email = :email';
    $stmPass = $conn->prepare($queryPassenger);
    $stmPass->execute(['email' => $email]);
    $passengerData = $stmPass->fetch(PDO::FETCH_ASSOC);

    if ($passengerData) {
        if ($password == $passengerData['password']) {
            session_start();
            $_SESSION['user'] = $passengerData['first_name'] . ' ' . $passengerData['last_name'];
            $_SESSION['user_id'] = $passengerData['passenger_id'];
            $_SESSION['role'] = 'passenger';
            $_SESSION['email'] = $passengerData['email'];

            echo json_encode([
                "status" => "success",
                "message" => 'Passenger logged in successfully',
                "role" => 'passenger'
            ]);
            return;
        } else {
            echo json_encode(["status" => "error", "message" => 'Incorrect password']);
            return;
        }
    }

    // ---------- If no match in both tables ----------
    echo json_encode(["status" => "error", "message" => 'User not found']);
}
?>
