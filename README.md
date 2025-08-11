<div align="center">
  <img src="public/asset/img/logo-undip.png" alt="Logo UNDIP" width="100" />
  <h1>Simple Student Monitoring System</h1>
  <p><i>A simple Laravel & MySQL-based student progress monitoring platform inspired by UNDIP’s SIAP (Sistem Informasi Akademik Universitas Diponegoro).</i></p>
</div>

---

## 📋 Overview

This is my **first group project** built with **PHP (Laravel)** and **MySQL**, designed to monitor students’ academic progress and status.  
The system supports **4 main roles**:

| Role          | Description |
|---------------|-------------|
| **Student**   | Views academic progress and personal study records. |
| **Advisor**   | Monitors and verifies the progress of assigned students. |
| **Department**| Oversees all students in the department. |
| **Admin**     | Manages system data and user accounts. |

I was responsible for **designing the database schema** and **co-developing the back-end** alongside one teammate.

---

## 🛠️ Tech Stack

- **Language**: PHP 8+
- **Framework**: Laravel
- **Database**: MySQL
- **Frontend**: Blade Templates, CSS, JavaScript
- **Others**: Bootstrap Icons

---

## 🚀 Installation Guide

```bash
# 1️⃣ Clone the repository
git clone https://github.com/bonifasiusbryan1/Simple-Student-Monitoring-System.git
cd Simple-Student-Monitoring-System

# 2️⃣ Install PHP dependencies
composer install

# 3️⃣ Install JS dependencies
npm install

# 4️⃣ Copy the environment file
cp .env.example .env
# Windows (PowerShell)
# copy .env.example .env

# 5️⃣ Configure database connection in .env
# Set DB_DATABASE to "monitoring_mahasiswa" and adjust username/password

# 6️⃣ Create the database (MySQL example)
mysql -u root -p -e "CREATE DATABASE monitoring_mahasiswa;"

# 7️⃣ Import the SQL file into the database
mysql -u root -p monitoring_mahasiswa < monitoring_mahasiswa.sql

# 8️⃣ Generate application key
php artisan key:generate

# 9️⃣ Create storage symlink
php artisan storage:link

# 🔟 Run the server
php artisan serve
# Access at: http://127.0.0.1:8000

---

## 📸 Screenshots
