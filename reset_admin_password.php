<?php
// Admin Password Reset Tool
// This script allows you to generate a new password hash for the admin user

include('server/connection.php');

$message = '';
$error = '';

if (isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password === $confirm_password) {
        if (strlen($new_password) >= 6) {
            // Generate new password hash
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update admin password
            $sql = "UPDATE users SET password = ? WHERE email = 'admin@velvetvogue.com' AND is_admin = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $hashed_password);
            
            if ($stmt->execute()) {
                $message = "Admin password updated successfully! New password: " . htmlspecialchars($new_password);
            } else {
                $error = "Error updating password: " . $conn->error;
            }
        } else {
            $error = "Password must be at least 6 characters long.";
        }
    } else {
        $error = "Passwords do not match.";
    }
}

// Display current admin info
$admin_query = "SELECT name, email FROM users WHERE is_admin = 1 LIMIT 1";
$admin_result = mysqli_query($conn, $admin_query);
$admin = mysqli_fetch_assoc($admin_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Password Reset - Velvet Vogue</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 50%, #FFCCCB 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        
        .reset-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        
        h2 {
            color: #FF1493;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .current-admin {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #FF1493;
        }
        
        .current-admin h3 {
            color: #FF1493;
            margin: 0 0 0.5rem 0;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #FF1493;
        }
        
        .btn-reset {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #FF1493 0%, #FF69B4 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .default-credentials {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        
        .navigation {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .navigation a {
            color: #FF1493;
            text-decoration: none;
            margin: 0 1rem;
            padding: 0.5rem 1rem;
            border: 2px solid #FF1493;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .navigation a:hover {
            background: #FF1493;
            color: white;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>🔐 Admin Password Reset</h2>
        
        <?php if ($admin): ?>
        <div class="current-admin">
            <h3>Current Admin Account</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($admin['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
        </div>
        <?php endif; ?>
        
        <div class="default-credentials">
            <h4>Default Login Credentials</h4>
            <p><strong>Email:</strong> admin@velvetvogue.com</p>
            <p><strong>Password:</strong> admin123</p>
            <p><em>Use these credentials if you haven't changed the password yet.</em></p>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required 
                       placeholder="Enter new password (min 6 characters)">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required 
                       placeholder="Confirm new password">
            </div>
            
            <button type="submit" name="reset_password" class="btn-reset">
                🔄 Reset Admin Password
            </button>
        </form>
        
        <div class="navigation">
            <a href="login.php">👤 Login</a>
            <a href="dashboard/dashboard.php">🏠 Dashboard</a>
            <a href="index.php">🌐 Main Site</a>
        </div>
    </div>
</body>
</html>
