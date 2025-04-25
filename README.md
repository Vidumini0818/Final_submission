# 🌟 Happelow Events Management System

## 📄 Description

**Happelow Events Management System** is a web-based platform that allows users to explore event packages, view service details, and manage bookings effectively. The system is built with a user-friendly interface and features robust database integration for seamless operation. Designed to streamline event planning, the platform supports secure user authentication, responsive layouts, and reliable database management.

## 🚀 Features

- 🎨 Intuitive and responsive UI for an excellent user experience
- 🔐 Secure user authentication (login, signup)
- 🗓️ Event package exploration and booking capabilities
- 📊 Dynamic database integration for managing bookings and services
- 📂 User-friendly navigation and categorized service display
- 🌍 Support for scalable operations and further enhancements

## 🏗️ Project Structure

```
project/
│
├── auth/                    # Authentication system (login, signup)
│   ├── Login.php
│   └── signup.php
├── css/                     # Stylesheets for various pages
│   ├── About.css
│   ├── Contact.css
│   ├── home.css
│   ├── login.css
│   ├── packages.css
│   ├── Service.css
│   └── Signup.css
├── Images/                  # Images for branding and visuals
│   ├── about.jpg
│   ├── home2.jpg
│   ├── home3.jpg
│   ├── home4.jpg
│   ├── icon1.png
│   ├── icon2.jpg
│   ├── icon3.png
│   └── logo2.webp
├── includes/                # Reusable backend code
│   └── db_connection.php
├── About.php                # About page
├── Contact.php              # Contact page
├── home.php                 # Homepage
├── packages.php             # Event packages page
├── Service.php              # Service details page
└── happelow_events_1.sql    # Database setup script
```

## 🛠️ Technologies Used

- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL
- **Tools/Environment:** XAMPP/WAMP/MAMP for local development

## ⚙️ Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/YourUsername/happelow-events.git
   ```

2. **Navigate to the project directory**
   ```bash
   cd happelow-events
   ```

3. **Set up the database**
   - Import `happelow_events_1.sql` into your MySQL database using phpMyAdmin or command line.
   - Update database credentials in `includes/db_connection.php`.

4. **Run the application**
   - Place the project folder in `htdocs` (for XAMPP) and start Apache/MySQL.
   - Access the application at:
     ```
     http://localhost/project/home.php
     ```

## 🤝 Contribution

Contributions are welcome! Feel free to fork the repository, submit a pull request, or open an issue to improve this project.

## 📄 License

This project is licensed under the **MIT License** – see the [LICENSE](LICENSE) file for details.

## 👤 Author

Developed by **[Vidumini Ishara]**  
viduuu0707@gmail.com 
