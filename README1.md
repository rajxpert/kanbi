# Employee Management Dashboard

A complete Employee Management System built with PHP and MySQL featuring attendance tracking with live photos, leave management, and salary slip generation.

## Features

### Employee Features:
- **Account Registration & Login**: Secure employee registration and authentication
- **Live Attendance**: Check-in/Check-out with live photo capture, time, and date
- **Leave Requests**: Submit leave requests with different types (sick, casual, annual, emergency)
- **Salary Slip Download**: Download monthly salary slips in PDF format
- **Professional Dashboard**: Clean and responsive UI

### Admin Features:
- **Employee Management**: Add, edit, view employee details
- **Attendance Monitoring**: View all employee attendance with live photos
- **Leave Approval**: Approve or reject employee leave requests
- **Salary Management**: Generate monthly salary slips for all employees
- **Dashboard Analytics**: Statistics and overview of the organization
- **Full Authorization**: Role-based access control

## Installation & Setup

### Prerequisites:
- XAMPP/WAMP/LAMP server
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser with camera access

### Setup Instructions:

1. **Clone/Download the project** to your web server directory:
   ```
   e:\PHP\Employ-Dashboard\
   ```

2. **Start your web server** (Apache and MySQL)

3. **Create Database**:
   - Open phpMyAdmin or MySQL command line
   - Import the `database.sql` file to create the database and tables
   - Or run the SQL commands manually from the file

4. **Configure Database Connection**:
   - Open `config/database.php`
   - Update database credentials if needed:
     ```php
     private $host = "localhost";
     private $db_name = "employee_management";
     private $username = "root";
     private $password = "";
     ```

5. **Set Permissions**:
   - Ensure `uploads/` folder has write permissions
   - Create folders if they don't exist:
     - `uploads/profiles/`
     - `uploads/attendance/`

6. **Access the Application**:
   - Open browser and go to: `http://localhost/Employ-Dashboard/`

## Default Login Credentials

### Admin Login:
- **Employee ID**: ADMIN001
- **Password**: password
- **Role**: Admin

### Employee Registration:
- Employees can register themselves through the registration page
- Admin can also add employees from the admin dashboard

## File Structure

```
Employ-Dashboard/
├── config/
│   └── database.php          # Database configuration
├── css/
│   └── style.css            # Main stylesheet
├── js/
│   └── script.js            # JavaScript for camera and interactions
├── uploads/
│   ├── profiles/            # Employee profile images
│   └── attendance/          # Attendance photos
├── index.php                # Login page
├── register.php             # Employee registration
├── login_process.php        # Login authentication
├── register_process.php     # Registration handler
├── employee_dashboard.php   # Employee main dashboard
├── admin_dashboard.php      # Admin main dashboard
├── attendance_action.php    # Attendance check-in/out handler
├── leave_request.php        # Leave request handler
├── approve_leave.php        # Admin leave approval
├── download_salary.php      # Salary slip download
├── employee_details.php     # Employee details view (admin)
├── logout.php              # Logout handler
└── database.sql            # Database structure and default data
```

## Key Features Explained

### 1. Live Photo Attendance
- Uses device camera to capture photos during check-in/check-out
- Photos are stored with timestamp and employee ID
- Admin can view all attendance photos for verification

### 2. Leave Management
- Employees can request different types of leaves
- System prevents overlapping leave requests
- Admin gets notifications for pending approvals
- Email notifications can be added for leave status updates

### 3. Salary Management
- Automatic salary slip generation
- Configurable salary components (basic, allowances, deductions)
- PDF download functionality
- Monthly salary processing

### 4. Security Features
- Password hashing using PHP's password_hash()
- Session-based authentication
- Role-based access control
- SQL injection prevention using prepared statements
- File upload validation

## Customization

### Adding New Departments:
Edit the department options in `register.php`:
```php
<option value="New Department">New Department</option>
```

### Modifying Salary Structure:
Update salary calculations in `download_salary.php`:
```php
$allowances = $basic_salary * 0.2; // 20% allowances
$deductions = $basic_salary * 0.1; // 10% deductions
```

### Changing Company Information:
Update company details in `download_salary.php` for salary slips.

## Browser Compatibility
- Chrome (recommended for camera features)
- Firefox
- Safari
- Edge

## Security Notes
- Change default admin password after first login
- Use HTTPS in production environment
- Regular database backups recommended
- Update file upload restrictions as needed

## Support
For any issues or customizations, refer to the code comments or contact the development team.

## License
This project is for educational and commercial use. Modify as needed for your organization.
