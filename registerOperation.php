<?php
$route = $_REQUEST['url'];
$route();

function registration() {
    include 'Connection/connection.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Get form data
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $passport_no = $_POST['passport_no'] ?? '';
    $DOB = $_POST['DOB'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $address = $_POST['address'] ?? '';

    // Server-side validation
    if (!$firstName) {
        echo json_encode(["status" => "error", "message" => 'First Name is required.']);
        return;
    }
    if (!$lastName) {
        echo json_encode(["status" => "error", "message" => 'Last Name is required.']);
        return;
    }
    if (!$email) {
        echo json_encode(["status" => "error", "message" => 'Email is required.']);
        return;
    }
    if (!$password) {
        echo json_encode(["status" => "error", "message" => 'Password is required.']);
        return;
    }
    if (!$confirmPassword) {
        echo json_encode(["status" => "error", "message" => 'Confirm Password is required.']);
        return;
    }
    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => 'Passwords do not match!']);
        return;
    }
    if (!$phone) {
        echo json_encode(["status" => "error", "message" => 'Phone is required.']);
        return;
    }
    if (!$gender) {
        echo json_encode(["status" => "error", "message" => 'Gender is required.']);
        return;
    }
    if (!$passport_no) {
        echo json_encode(["status" => "error", "message" => 'Passport Number is required.']);
        return;
    }
    if (!$DOB) {
        echo json_encode(["status" => "error", "message" => 'Date of Birth is required.']);
        return;
    }
    if (!$nationality) {
        echo json_encode(["status" => "error", "message" => 'Nationality is required.']);
        return;
    }
    if (!$address) {
        echo json_encode(["status" => "error", "message" => 'Address is required.']);
        return;
    }
    

    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => 'Passwords do not match!']);
        return;
    }

    try {
        $db = new DatabaseConnection();
        $conn = $db->getConnection();

        // Check if email exists
        $emailCheck = "SELECT COUNT(*) FROM passengers WHERE email = :email";
        $stm = $conn->prepare($emailCheck);
        $stm->bindParam(':email', $email);
        $stm->execute();
        $emailExists = $stm->fetchColumn();

        if ($emailExists > 0) {
            echo json_encode(["status" => "error", "message" => 'Email already exists']);
            return;
        }


        $conn->beginTransaction();

        // Insert into passengers table
        $stmt = $conn->prepare("INSERT INTO passengers 
            (first_name, last_name, email, password, phone, gender, passport_no, date_of_birth, nationality, address) 
            VALUES 
            (:firstName, :lastName, :email, :password, :phone, :gender, :passport_no, :DOB, :nationality, :address)");

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':passport_no', $passport_no);
        $stmt->bindParam(':DOB', $DOB);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':address', $address);

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['status' => 'error', 'message' => 'SQL Error: ' . $errorInfo[2]]);
            return;
        }

        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Signup successful!']);

    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.',
            'error_details' => $e->getMessage()
        ]);
    }
}
?>
