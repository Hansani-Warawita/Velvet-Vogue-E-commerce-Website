<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('server/connection.php');

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        $errors = [];
        
        // Validate name
        if (empty($name)) {
            $errors[] = "Name is required";
        } elseif (strlen($name) < 2) {
            $errors[] = "Name must be at least 2 characters long";
        }
        
        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        } else {
            // Check if email already exists for other users
            $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
            $stmt->bind_param('si', $email, $user_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $errors[] = "Email already exists";
            }
        }
        
        // If password change is requested
        if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
            if (empty($current_password)) {
                $errors[] = "Current password is required to change password";
            } else {
                // Verify current password
                $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $user_data = $result->fetch_assoc();
                
                if (!password_verify($current_password, $user_data['password'])) {
                    $errors[] = "Current password is incorrect";
                }
            }
            
            if (empty($new_password)) {
                $errors[] = "New password is required";
            } elseif (strlen($new_password) < 6) {
                $errors[] = "New password must be at least 6 characters long";
            }
            
            if ($new_password !== $confirm_password) {
                $errors[] = "New passwords do not match";
            }
        }
        
        // If no errors, update the profile
        if (empty($errors)) {
            try {
                if (!empty($new_password)) {
                    // Update with new password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?");
                    $stmt->bind_param('sssi', $name, $email, $hashed_password, $user_id);
                } else {
                    // Update without password change
                    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
                    $stmt->bind_param('ssi', $name, $email, $user_id);
                }
                
                if ($stmt->execute()) {
                    $_SESSION['user_name'] = $name; // Update session name
                    $success_message = "Profile updated successfully!";
                } else {
                    $error_message = "Error updating profile. Please try again.";
                }
            } catch (Exception $e) {
                $error_message = "Error updating profile: " . $e->getMessage();
            }
        } else {
            $error_message = implode(", ", $errors);
        }
    }
}

// Get current user information
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information - Velvet Vogue</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sytle/style.css">
</head>
<body>
    <?php include('footer and header/header.php'); ?>

    <div class="account-info-container">
        <div class="account-info-header">
            <h2>Account Information</h2>
            <p>Update your personal details and security settings</p>
        </div>

        <?php if ($success_message): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="account-info-content">
            <div class="profile-section">
                <div class="section-header">
                    <h3><i class="fas fa-user"></i> Personal Information</h3>
                </div>

                <form method="POST" class="profile-form">
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-divider">
                        <span>Password Settings</span>
                    </div>

                    <div class="form-group">
                        <label for="current_password">
                            <i class="fas fa-lock"></i>
                            Current Password
                        </label>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password to change password">
                        <small>Leave blank if you don't want to change your password</small>
                    </div>

                    <div class="form-group">
                        <label for="new_password">
                            <i class="fas fa-key"></i>
                            New Password
                        </label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                        <small>Minimum 6 characters required</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">
                            <i class="fas fa-key"></i>
                            Confirm New Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="update_profile" class="btn-update">
                            <i class="fas fa-save"></i>
                            Update Profile
                        </button>
                        <a href="account.php" class="btn-cancel">
                            <i class="fas fa-arrow-left"></i>
                            Back to Account
                        </a>
                    </div>
                </form>
            </div>

            <div class="account-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h4>Member Since</h4>
                        <p><?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-info">
                        <h4>Total Orders</h4>
                        <p>
                            <?php
                            $stmt = $conn->prepare("SELECT COUNT(*) as order_count FROM orders WHERE user_id = ?");
                            $stmt->bind_param('i', $user_id);
                            $stmt->execute();
                            $order_count = $stmt->get_result()->fetch_assoc()['order_count'];
                            echo $order_count;
                            ?>
                        </p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h4>Account Status</h4>
                        <p>Active Member</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer and header/footer.php'); ?>

    <script>
        // Enhanced account information page functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Page load animations
            const animateElements = document.querySelectorAll('.profile-section, .stat-card');
            animateElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Show/hide password fields based on current password input
            const currentPasswordField = document.getElementById('current_password');
            const newPasswordField = document.getElementById('new_password');
            const confirmPasswordField = document.getElementById('confirm_password');

            currentPasswordField.addEventListener('input', function() {
                if (this.value.length > 0) {
                    newPasswordField.required = true;
                    confirmPasswordField.required = true;
                    newPasswordField.parentElement.style.opacity = '1';
                    confirmPasswordField.parentElement.style.opacity = '1';
                } else {
                    newPasswordField.required = false;
                    confirmPasswordField.required = false;
                    newPasswordField.value = '';
                    confirmPasswordField.value = '';
                    newPasswordField.parentElement.style.opacity = '0.6';
                    confirmPasswordField.parentElement.style.opacity = '0.6';
                }
            });

            // Initialize password field states
            if (currentPasswordField.value.length === 0) {
                newPasswordField.parentElement.style.opacity = '0.6';
                confirmPasswordField.parentElement.style.opacity = '0.6';
            }

            // Password confirmation validation
            confirmPasswordField.addEventListener('input', function() {
                const newPassword = newPasswordField.value;
                const confirmPassword = this.value;
                
                if (newPassword !== confirmPassword && confirmPassword.length > 0) {
                    this.setCustomValidity('Passwords do not match');
                    this.style.borderColor = '#dc3545';
                } else {
                    this.setCustomValidity('');
                    this.style.borderColor = '';
                }
            });

            // Real-time password strength indicator
            newPasswordField.addEventListener('input', function() {
                const password = this.value;
                const strengthIndicator = this.parentElement.querySelector('.password-strength') || 
                                        this.insertAdjacentElement('afterend', createPasswordStrengthIndicator());
                
                updatePasswordStrength(password, strengthIndicator);
            });

            // Form submission with loading state
            const form = document.querySelector('.profile-form');
            const updateButton = document.querySelector('.btn-update');
            
            form.addEventListener('submit', function() {
                updateButton.disabled = true;
                updateButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                
                // Re-enable after 3 seconds as fallback
                setTimeout(() => {
                    updateButton.disabled = false;
                    updateButton.innerHTML = '<i class="fas fa-save"></i> Update Profile';
                }, 3000);
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.form-group input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Auto-hide success/error messages
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        message.remove();
                    }, 300);
                }, 5000);
            });
        });

        // Create password strength indicator
        function createPasswordStrengthIndicator() {
            const indicator = document.createElement('div');
            indicator.className = 'password-strength';
            indicator.innerHTML = `
                <div class="strength-bar">
                    <div class="strength-fill"></div>
                </div>
                <small class="strength-text">Password strength</small>
            `;
            return indicator;
        }

        // Update password strength
        function updatePasswordStrength(password, indicator) {
            const strengthFill = indicator.querySelector('.strength-fill');
            const strengthText = indicator.querySelector('.strength-text');
            
            let strength = 0;
            let text = 'Very Weak';
            let color = '#dc3545';
            
            if (password.length >= 6) strength += 20;
            if (password.length >= 8) strength += 20;
            if (/[a-z]/.test(password)) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/\d/.test(password)) strength += 10;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 10;
            
            if (strength >= 80) {
                text = 'Very Strong';
                color = '#28a745';
            } else if (strength >= 60) {
                text = 'Strong';
                color = '#6f42c1';
            } else if (strength >= 40) {
                text = 'Medium';
                color = '#fd7e14';
            } else if (strength >= 20) {
                text = 'Weak';
                color = '#ffc107';
            }
            
            strengthFill.style.width = strength + '%';
            strengthFill.style.backgroundColor = color;
            strengthText.textContent = text;
            strengthText.style.color = color;
        }
    </script>
</body>
</html>
