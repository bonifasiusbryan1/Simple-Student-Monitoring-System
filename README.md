# 🎓 Simple Student Monitoring System

<div align="center">
  
  ![Logo UNDIP](public/asset/img/logo-undip.png)
  
  ### *A comprehensive Laravel-MySQL student progress monitoring platform*
  
  [![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
  [![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
  [![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com/)
  [![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)
  
  *Inspired by UNDIP's SIAP (Sistem Informasi Akademik Universitas Diponegoro)*
  
</div>

---

## ✨ Overview

> **My first group project** showcasing academic progress monitoring with multi-role authentication system.

This comprehensive student monitoring system provides a seamless experience for tracking academic progress across multiple user roles. Built with modern web technologies, it offers intuitive interfaces for students, advisors, departments, and system operators.

### 🎯 Key Features

- 📊 **Real-time Progress Tracking** - Monitor academic performance instantly
- 👥 **Multi-Role Authentication** - Secure access for different user types
- 📈 **Analytics Dashboard** - Comprehensive data visualization
- 🔐 **Secure Data Management** - Robust user authentication and authorization
- 📱 **Responsive Design** - Works seamlessly across all devices

---

## 👥 User Roles & Permissions

<div align="center">

| 🎓 Role | 📝 Description | 🔑 Key Features |
|---------|----------------|------------------|
| **Mahasiswa** | Student portal for academic tracking | View progress, grades, and study records |
| **Dosen Wali** | Academic advisor supervision | Monitor and verify student progress |
| **Departemen** | Department-level oversight | Comprehensive student analytics |
| **Operator** | System administration | User management and data control |

</div>

> **My Contribution:** Led database schema design and co-developed the entire back-end architecture

---

## 🛠️ Technology Stack

<div align="center">

### Backend
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)

### Frontend
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white)

</div>

---

## 📸 Application Screenshots

<details>
<summary>🖼️ <strong>Click to view application interface</strong></summary>

<br>

<div align="center">

### 🔐 Authentication
<img src="public/screenshots/login.png" alt="Login Interface" width="600" />

### 🎓 Student Dashboard
<img src="public/screenshots/mahasiswa_dashboard.png" alt="Student Portal" width="600" />

### 👨‍🏫 Academic Advisor Portal
<img src="public/screenshots/dosenwali_dashboard.png" alt="Advisor Interface" width="600" />

### 🏢 Department Overview
<img src="public/screenshots/departemen_rekapMahasiswa.png" alt="Department Analytics" width="600" />

### ⚙️ System Administration
<img src="public/screenshots/operator_progresStudi.png" alt="Admin Panel" width="600" />

</div>

</details>

---

## 🚀 Quick Start Guide

### Prerequisites
- 🐘 **PHP 8.1+**
- 🎵 **Composer**
- 🗄️ **MySQL 8.0+**
- 📦 **Node.js & NPM**

### Installation

```bash
# 📥 Clone the repository
git clone https://github.com/bonifasiusbryan1/Simple-Student-Monitoring-System.git
cd Simple-Student-Monitoring-System

# 📦 Install dependencies
composer install && npm install

# ⚙️ Environment setup
cp .env.example .env
# Configure your database settings in .env

# 🗄️ Database setup
mysql -u root -p -e "CREATE DATABASE monitoring_mahasiswa;"
mysql -u root -p monitoring_mahasiswa < monitoring_mahasiswa.sql

# 🔑 Generate application key
php artisan key:generate

# 🔗 Create storage symlink
php artisan storage:link

# 🚀 Launch the application
php artisan serve
```

### 🌐 Access the Application
Open your browser and navigate to: `http://127.0.0.1:8000`

---

## 📂 Project Structure

```
Simple-Student-Monitoring-System/
├── 📁 app/                 # Application core files
├── 📁 database/            # Database migrations & seeds
├── 📁 public/              # Public assets & screenshots
├── 📁 resources/           # Views, CSS, JS resources
├── 📁 routes/              # Application routes
└── 📄 monitoring_mahasiswa.sql  # Database schema
```

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. 🍴 Fork the project
2. 🌿 Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. 💾 Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. 📤 Push to the branch (`git push origin feature/AmazingFeature`)
5. 🔄 Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

<div align="center">

### 💝 Support This Project

If you found this project helpful, please consider giving it a ⭐️!

**Built with ❤️ for academic excellence**

---

*© 2024 Simple Student Monitoring System. All rights reserved.*

</div>
