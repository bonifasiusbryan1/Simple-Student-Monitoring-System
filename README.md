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
| **Operator**     | Manages system data and user accounts. |

I was responsible for **designing the database schema** and **co-developing the back-end** alongside one teammate.

---

## 🛠️ Tech Stack

- **Language**: PHP
- **Framework**: Laravel 10
- **Database**: MySQL
- **Frontend**: Blade Templates, CSS, JavaScript
- **Others**: Bootstrap Icons

---

## 📸 Screenshots

<table>
  <tr>
    <td align="center">
      <img src="public/screenshots/login.png" alt="Login Page" width="420"><br>
      <sub><b>Login Page</b></sub>
    </td>
    <td align="center">
      <img src="public/screenshots/mahasiswa_dashboard.png" alt="Student (Dashboard)" width="420"><br>
      <sub><b>Student (Dashboard)</b></sub>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="public/screenshots/dosenwali_dashboard.png" alt="Advisor (Dashboard)" width="280"><br>
      <sub><b>Advisor (Dashboard)</b></sub>
    </td>
    <td align="center">
      <img src="public/screenshots/departemen_rekapMahasiswa.png" alt="Department (Rekap Mahasiswa)" width="280"><br>
      <sub><b>Department (Rekap Mahasiswa)</b></sub>
    </td>
    <td align="center">
      <img src="public/screenshots/operator_progresStudi.png" alt="Operator (Progress Studi)" width="280"><br>
      <sub><b>Operator (Progress Studi)</b></sub>
    </td>
  </tr>
</table>

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
