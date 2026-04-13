<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="card">
            <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Employee Management System</h2>
            
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            
            <form action="login_process.php" method="POST" id="loginForm">
                <input type="hidden" id="location" name="location" value="">
                
                <div class="form-group">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" id="employee_id" name="employee_id" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Login As:</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="employee">Employee</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Don't have an account? <a href="register.php" style="color: #667eea;">Register here</a></p>
            </div>
        </div>
    </div>
    
    <script src="js/script.js"></script>
    <script>
        // Get user location on page load
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const location = position.coords.latitude + ',' + position.coords.longitude;
                document.getElementById('location').value = location;
            }, function() {
                document.getElementById('location').value = 'Location denied';
            });
        } else {
            document.getElementById('location').value = 'Location not supported';
        }
    </script>
</body>
</html>
