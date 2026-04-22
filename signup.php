<?php
session_start();
include('server/connection.php');

// Check if user came from checkout
if(isset($_GET['checkout']) && $_GET['checkout'] == '1') {
    $_SESSION['checkout_redirect'] = true;
}

if(isset($_POST['signup_btn'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    $errors = array();

    // Validate name
    if(empty($name)) {
        $errors[] = "Name is required";
    } elseif(strlen($name) < 3) {
        $errors[] = "Name must be at least 3 characters long";
    }

    // Validate email
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) {
            $errors[] = "Email already exists";
        }
    }

    // Validate password
    if(empty($password)) {
        $errors[] = "Password is required";
    } elseif(strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }

    // Confirm password
    if($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // If no errors, proceed with registration
    if(empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $hashed_password);
        
        if($stmt->execute()) {
            // Get the user_id of new registration
            $user_id = $stmt->insert_id;
            
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['is_admin'] = false;
            
            // Check if user was trying to checkout
            if(isset($_SESSION['checkout_redirect'])) {
                unset($_SESSION['checkout_redirect']);
                header('location: checkout.php');
            } else {
                header('location: index.php?registration=success');
            }
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="signup.php" class="login-form signup-form">
            <h2>Create an Account</h2>
            
            <?php if(!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small class="password-hint">Must be at least 6 characters long</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" name="signup_btn" class="login-button">Sign Up</button>

            <p class="signup-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
