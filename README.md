# Spacey - NGO Chatbot

A modern, interactive chatbot application designed for NGOs to collect parent and child information through an engaging, child-friendly interface. Built with PHP, MySQL, and vanilla JavaScript.

## Features

- **Interactive Chat Interface**: Floating chat button with smooth animations
- **Child-Friendly Design**: Colorful UI with comic sans font and playful elements
- **Real-time Validation**: Input validation for email, phone, age, and gender
- **Responsive Design**: Mobile-friendly interface
- **Data Collection**: Comprehensive parent and child information gathering
- **Database Integration**: MySQL backend for data persistence
- **Status Tracking**: Query status management (Pending, Reviewed, Resolved)

## Requirements

- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher (MariaDB 10.4+ recommended)
- **Web Server**: Apache/Nginx with PHP support
- **Browser**: Modern browser with JavaScript enabled

## Installation & Setup

### 1. Clone or Download the Project

```bash
git clone https://github.com/vikashkumarsingh21/chatbot.git
cd chatbot
```

### 2. Database Setup

1. **Create Database**:
   ```sql
   CREATE DATABASE ngo_chatbot;
   ```

2. **Import Table Structure**:
   - Open phpMyAdmin or your MySQL client
   - Select the `ngo_chatbot` database
   - Import the `table_structure` file

   Or run the SQL commands manually from `table_structure` file.

### 3. Configure Database Connection

Edit `config/db.php` and update the database credentials:

```php
<?php
$conn = new mysqli("localhost", "your_username", "your_password", "ngo_chatbot");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
```

**Default configuration**:
- Host: `localhost`
- Username: `root`
- Password: (empty)
- Database: `ngo_chatbot`

### 4. Web Server Configuration

#### Option A: Using XAMPP/WAMP
1. Copy the project folder to `htdocs` (XAMPP) or `www` (WAMP)
2. Start Apache and MySQL services
3. Access: `http://localhost/ngo-chatbot/`

#### Option B: Using Built-in PHP Server
```bash
cd /path/to/your/project
php -S localhost:8000
```
Access: `http://localhost:8000/`

#### Option C: Apache/Nginx Configuration
Ensure your web server points to the project root directory and PHP is properly configured.

## Project Structure

```
chatbot/
├── index.php              # Main frontend (HTML/CSS/JS)
├── api/
│   └── chatbot.php        # Backend API for data processing
├── config/
│   └── db.php            # Database configuration
├── table_structure       # MySQL database schema
├── LICENSE               # MIT License
└── README.md            # This file
```

## Configuration

### Database Connection
Modify `config/db.php` to match your database setup:

```php
$conn = new mysqli("HOST", "USERNAME", "PASSWORD", "DATABASE_NAME");
```

### Chatbot Questions
Edit the `questions` array in `index.php` to customize the conversation flow:

```javascript
const questions = [
    "What is your first name? ",
    "What's your middle name? (optional)",
    "And your last name? ",
    // ... more questions
];
```

### Validation Rules
Modify validation logic in `index.php`:

- **Email**: Regex pattern for email validation
- **Phone**: 10-digit number validation
- **Age**: Range 1-18 years
- **Gender**: Accepts Male/Female/Other

## Customization

### Chatbot Behavior
- **Auto-capitalization**: Names are automatically capitalized
- **Input validation**: Prevents invalid data submission
- **Error handling**: User-friendly error messages
- **Success feedback**: Confirmation message after submission

## Database Schema

### parent_chat Table

| Field | Type | Description |
|-------|------|-------------|
| id | INT | Primary key, auto-increment |
| first_name | VARCHAR(50) | Parent's first name |
| middle_name | VARCHAR(50) | Parent's middle name (optional) |
| last_name | VARCHAR(50) | Parent's last name |
| email | VARCHAR(100) | Parent's email (unique) |
| phone | VARCHAR(15) | Parent's phone number |
| child_name | VARCHAR(50) | Child's name |
| child_age | INT | Child's age (1-18) |
| child_gender | VARCHAR(10) | Child's gender (Male/Female/Other) |
| parent_query | TEXT | Parent's query/message |
| status | ENUM | Query status (Pending/Reviewed/Resolved) |
| created_at | TIMESTAMP | Record creation time |

**Unique Constraint**: `email`, `phone`, `child_name` combination

## Security Features

- **Input Validation**: Client-side validation for all inputs
- **SQL Injection Protection**: Prepared statements in PHP
- **Data Sanitization**: Automatic capitalization of names
- **Error Handling**: Graceful error messages without exposing sensitive information

## Usage

1. **Access the Application**: Open `index.php` in your web browser
2. **Start Chat**: Click the floating orange chatbot button
3. **Fill Information**: Answer the chatbot's questions sequentially
4. **Submit Query**: Provide your query after filling all required information
5. **Confirmation**: Receive success message upon completion

## Troubleshooting

### Common Issues

1. **Database Connection Error**:
   - Verify database credentials in `config/db.php`
   - Ensure MySQL service is running
   - Check database name and table existence

2. **Blank Page**:
   - Check PHP error logs
   - Verify file permissions
   - Ensure PHP is properly installed

3. **JavaScript Not Working**:
   - Check browser console for errors
   - Ensure JavaScript is enabled
   - Verify file paths are correct

4. **Data Not Saving**:
   - Check database connection
   - Verify table structure matches schema
   - Check PHP error logs

### Debug Mode
Enable error reporting by adding to the top of PHP files:

```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


## 🙏 Acknowledgments

- Built for NGO communication and data collection
- Designed with children and parents in mind
- Responsive and accessible interface
- Modern web technologies stack

---
