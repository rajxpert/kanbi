<?php
class Database {
    // Hostinger database configuration
    private $host = "localhost"; // Hostinger MySQL host
    private $db_name = "u931931458_employee"; // Replace with your Hostinger database name
    private $username = "u931931458_employee"; // Replace with your Hostinger database username
    private $password = "Rajpk583@#"; // Replace with your Hostinger database password
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Set timezone to India
            date_default_timezone_set('Asia/Kolkata');
            
            // Direct connection to existing database on Hostinger
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            
            // Check if tables exist, if not create them
            $this->setupTables();
            
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
    private function setupTables() {
        try {
            // Check if users table exists
            $result = $this->conn->query("SHOW TABLES LIKE 'users'");
            if ($result->rowCount() == 0) {
                // Create all tables
                $sql = "
                CREATE TABLE users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    employee_id VARCHAR(20) UNIQUE NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    email VARCHAR(100) UNIQUE NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    phone VARCHAR(15),
                    department VARCHAR(50),
                    position VARCHAR(50),
                    salary DECIMAL(10,2),
                    join_date DATE,
                    profile_image VARCHAR(255),
                    role ENUM('employee', 'admin') DEFAULT 'employee',
                    status ENUM('active', 'inactive') DEFAULT 'active',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
                
                CREATE TABLE attendance (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    employee_id VARCHAR(20),
                    check_in_time DATETIME,
                    check_out_time DATETIME,
                    check_in_photo VARCHAR(255),
                    check_out_photo VARCHAR(255),
                    date DATE,
                    status ENUM('present', 'absent', 'late') DEFAULT 'present',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (employee_id) REFERENCES users(employee_id)
                );
                
                CREATE TABLE leave_requests (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    employee_id VARCHAR(20),
                    leave_type ENUM('sick', 'casual', 'annual', 'emergency') NOT NULL,
                    start_date DATE NOT NULL,
                    end_date DATE NOT NULL,
                    reason TEXT,
                    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                    admin_comment TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (employee_id) REFERENCES users(employee_id)
                );
                
                CREATE TABLE salary_slips (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    employee_id VARCHAR(20),
                    month VARCHAR(7),
                    basic_salary DECIMAL(10,2),
                    allowances DECIMAL(10,2),
                    deductions DECIMAL(10,2),
                    net_salary DECIMAL(10,2),
                    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (employee_id) REFERENCES users(employee_id)
                );
                ";
                
                $this->conn->exec($sql);
                
                // Insert default admin
                $admin_password = password_hash('password', PASSWORD_DEFAULT);
                $admin_sql = "INSERT INTO users (employee_id, name, email, password, role) 
                             VALUES ('ADMIN001', 'System Admin', 'admin@company.com', '$admin_password', 'admin')";
                $this->conn->exec($admin_sql);
            }
        } catch(PDOException $exception) {
            echo "Setup error: " . $exception->getMessage();
        }
    }
}
?>