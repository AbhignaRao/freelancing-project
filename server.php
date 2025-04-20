<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database configuration
require_once 'config.php';

// Initialize variables
$username = "";
$email = "";
$errors = array();

// Register user
if (isset($_POST['reg_user'])) {
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password_1 = sanitize_input($_POST['password_1']);
    $password_2 = sanitize_input($_POST['password_2']);
    $type = sanitize_input($_POST['type']);

    // Form validation
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) { array_push($errors, "Passwords do not match"); }

    // Check for existing user
    $user_check_query = "SELECT * FROM user WHERE username='$username' OR email='$email' LIMIT 1";
    $result = safe_query($user_check_query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Register user if no errors
    if (count($errors) == 0) {
        $password = md5($password_1); // Hash password
        $query = "INSERT INTO user (username, email, password, type) 
                  VALUES('$username', '$email', '$password', '$type')";
        
        if (safe_query($query)) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['type'] = $type;
            
            if ($type == "freelancer") {
                header('location: freelancerProfile.php');
            } else {
                header('location: employerProfile.php');
            }
        } else {
            array_push($errors, "Registration failed. Please try again.");
        }
    }
}

// Login user
if (isset($_POST['login_user'])) {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        $results = safe_query($query);

        if ($results && $results->num_rows == 1) {
            $user = $results->fetch_assoc();
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['type'] = $user['type'];
            
            if ($user['type'] == "freelancer") {
                header('location: freelancerProfile.php');
            } else {
                header('location: employerProfile.php');
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

// Search functionality
function perform_search($table, $fields, $search_term) {
    return search_query($table, $fields, $search_term);
}

if(isset($_POST["register"])){
    try {
        // Check if all required fields are set
        $required_fields = ["username", "name", "email", "password", "repassword", "contactNo", "gender", "birthdate", "address", "usertype"];
        foreach($required_fields as $field) {
            if(!isset($_POST[$field]) || empty($_POST[$field])) {
                throw new Exception("All fields are required");
            }
        }

        // Get and sanitize all input fields
        $username = sanitize_input($_POST["username"]);
        $name = sanitize_input($_POST["name"]);
        $email = sanitize_input($_POST["email"]);
        $password = sanitize_input($_POST["password"]);
        $repassword = sanitize_input($_POST["repassword"]);
        $contactNo = sanitize_input($_POST["contactNo"]);
        $gender = sanitize_input($_POST["gender"]);
        $birthdate = sanitize_input($_POST["birthdate"]);
        $address = sanitize_input($_POST["address"]);
        $usertype = sanitize_input($_POST["usertype"]);

        // Validate passwords match
        if($password !== $repassword) {
            throw new Exception("Passwords do not match");
        }

        // Validate email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Validate password strength
        if(strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long");
        }

        // Hash the password for security
        $hashed_password = md5($password); // Using MD5 for compatibility with existing data

        // Check if username already exists
        $sql = "SELECT username FROM freelancer WHERE username = ? 
                UNION 
                SELECT username FROM employer WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            throw new Exception("Username already exists");
        }

        // Begin transaction
        $conn->begin_transaction();

        try {
            if ($usertype == "freelancer") {
                $sql = "INSERT INTO freelancer (username, password, Name, email, contact_no, address, gender, birthdate) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssss", $username, $hashed_password, $name, $email, $contactNo, $address, $gender, $birthdate);
                
                if($stmt->execute()) {
                    $conn->commit();
                    $_SESSION["Username"] = $username;
                    $_SESSION["Usertype"] = 1;
                    header("location: freelancerProfile.php");
                    exit();
                } else {
                    throw new Exception("Registration failed");
                }
            } 
            else if ($usertype == "employer") {
                $sql = "INSERT INTO employer (username, password, Name, email, contact_no, address, gender, birthdate) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssss", $username, $hashed_password, $name, $email, $contactNo, $address, $gender, $birthdate);
                
                if($stmt->execute()) {
                    $conn->commit();
                    $_SESSION["Username"] = $username;
                    $_SESSION["Usertype"] = 2;
                    header("location: employerProfile.php");
                    exit();
                } else {
                    throw new Exception("Registration failed");
                }
            } 
            else {
                throw new Exception("Invalid user type");
            }
        } 
        catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }
    }
    catch (Exception $e) {
        $_SESSION["error"] = $e->getMessage();
        $_SESSION["form_data"] = $_POST;
    }
}

if(isset($_POST["login"])){
    session_unset();
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    $usertype = sanitize_input($_POST["usertype"]);
    
    // Hash the password using MD5 for comparison
    $hashed_password = md5($password);

    if ($usertype=="freelancer") {
        $sql = "SELECT * FROM freelancer WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result && $result->num_rows == 1){
            $user = $result->fetch_assoc();
            $_SESSION["Username"] = $username;
            $_SESSION["Usertype"] = 1;
            header("location: freelancerProfile.php");
            exit();
        } else {
            $_SESSION["error"] = "Username/password is incorrect";
        }
    } else {
        $sql = "SELECT * FROM employer WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result && $result->num_rows == 1){
            $user = $result->fetch_assoc();
            $_SESSION["Username"] = $username;
            $_SESSION["Usertype"] = 2;
            header("location: employerProfile.php");
            exit();
        } else {
            $_SESSION["error"] = "Username/password is incorrect";
        }
    }
}

if(isset($_SESSION["error"])){
    $errorMsg=$_SESSION["error"];
    unset($_SESSION["error"]);
}
else{
    $errorMsg="";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>