# Faliz-Ecommerce - Modern PHP eCommerce Platform

[![PHP Version](https://img.shields.io/badge/PHP-8.x-777bb4.svg?style=flat-square&logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1.svg?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg?style=flat-square&logo=tailwind-css)](https://tailwindcss.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

**Faliz-Ecommerce** is a sleek, modern eCommerce web application built with PHP and MySQL. It features a minimalist aesthetic, responsive design, and a full-featured administrative dashboard for managing sales, orders, and products.

##  Features

### Customer Experience
- **Elegant Shop Interface**: Browse products with high-quality imagery and clean typography.
- **Shopping Cart & Wishlist**: Seamlessly manage items you intend to buy.
- **Checkout System**: Integrated flow for placing orders and managing shipping details.
- **User Profiles**: Customers can track their orders and manage personal information.
- **Responsive Design**: Fully optimized for mobile, tablet, and desktop viewing.

### Admin Dashboard
- **Analytics Overview**: Real-time sales summaries and inventory statistics using Chart.js.
- **Order Management**: Track and update the status of customer orders.
- **Product Management**: Complete CRUD functionality for adding, editing, and removing products.
- **User Management**: Oversee customer accounts and administrative roles.

##  Tech Stack

- **Backend**: PHP (Procedural)
- **Database**: MySQL
- **Frontend**: 
  - Tailwind CSS (via CDN)
  - Google Fonts (Outfit)
  - FontAwesome 6 icons
- **Visuals**: Chart.js for data visualization

##  Installation & Setup

### Prerequisites
- PHP server (XAMPP, WAMP, Laragon, etc.)
- MySQL database

### Setup Steps
1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/faliz-ecommerce.git
   ```

2. **Database Configuration**:
   - Create a new database in MySQL (e.g., `faliz_db`).
   - Import the `database.sql` file provided in the root directory.

3. **Environment Setup**:
   - Open `includes/db.php` and update the connection details:
     ```php
     $servername = "localhost";
     $username = "root"; // your mysql username
     $password = "";     // your mysql password
     $dbname = "faliz_db";
     ```

4. **Run the Project**:
   - Move the project folder to your local server directory (e.g., `C:/xampp/htdocs/Faliz-Ecommerce`).
   - Access the project via `http://localhost/Faliz-Ecommerce/index.php`.

##  Admin Access

- To access the admin panel, navigate to `/admin`.
- **Default Admin Credentials**: Refer to the `users` table in the database for admin accounts.

##  Authors

This project was developed through a collaborative partnership between **Mohamed Dahir** and **Faliz Mohamed**. Together, we combined our technical skills and design vision to create a modern, high-performance eCommerce solution that balances aesthetics with robust functionality.

Working side-by-side, we managed every aspect of the build, from the initial database architecture to the final touches of the user interface. Our combined efforts ensured that both the customer experience and the administrative tools were built to a premium standard, reflecting our shared commitment to clean code and exceptional user experience.

##  Contributing

Contributions, issues, and feature requests are welcome!

##  License

This project is licensed under the MIT License.


