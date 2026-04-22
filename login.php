<?php
session_start();
include('server/connection.php');

if(isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, name, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name, $hashed_password, $is_admin);
        $stmt->fetch();

        if(password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;
            $_SESSION['is_admin'] = $is_admin;
            
            // Check if user was trying to checkout
            if(isset($_SESSION['checkout_redirect'])) {
                unset($_SESSION['checkout_redirect']);
                header('location: checkout.php');
            } elseif($is_admin) {
                header('location: dashboard/dashboard.php');
            } else {
                header('location: index.php');
            }
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <div class="login-container">
        <form method="POST" action="login.php" class="login-form">
            <h2>Login to Velvet Vogue</h2>
            
            <?php if(isset($_GET['message']) && $_GET['message'] == 'login_required'): ?>
                <div class="info-message">Please login to proceed to checkout.</div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" name="login_btn" class="login-button">Login</button>

            <p class="signup-link">Don't have an account? <a href="signup.php<?php echo (isset($_GET['message']) && $_GET['message'] == 'login_required') ? '?checkout=1' : ''; ?>">Sign up</a></p>
        </form>
    </div>
</body>
</html>
