<div align="center">
  <img src="public/asset/img/logo-undip.png" alt="Logo UNDIP" width="100" />
  <h1>Simple Student Monitoring System</h1>
  <p><i>A simple Laravel & MySQL-based student progress monitoring platform inspired by UNDIP’s SIAP.</i></p>
</div>

---

## 📋 Overview

This is our **first group project** built with **PHP (Laravel)** and **MySQL**, designed to monitor students’ academic progress and status.  
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
# 1. Clone the repository
git clone https://github.com/bonifasiusbryan1/Simple-Student-Monitoring-System.git
cd Simple-Student-Monitoring-System

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy .env file
cp .env.example .env
# Windows (PowerShell)
# copy .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Run migrations & seed
php artisan migrate --seed

# 7. Create storage symlink
php artisan storage:link

# 8. Run the server
php artisan serve
# Access at: http://127.0.0.1:8000
