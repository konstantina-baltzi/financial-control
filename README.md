# 📊 Financial Control Application

A modern, lightweight web application for tracking and managing monthly/yearly financial obligations and bills, built with **Laravel 11**. This app helps users monitor their expenses, keep track of pending, paid, or overdue bills, and fully supports **dual-language switching (English & Greek)**.

---

## ✨ Features

* **Bills Management (Full CRUD):** Create, read, update, and delete financial obligations with fields for title, amount, payment date, due date, and custom notes.
* **Smart Color-Coded Styling:**
    * 🟩 **Green:** Fully paid bills.
    * 🟥 **Red:** Overdue bills (🚨 *OVERDUE!* badge).
    * 🟨 **Yellow:** Upcoming bills expiring soon (within 5 days).
    * 🟦 **Soft Blue:** Pending bills with plenty of time left.
* **Category Management:** Create custom categories with a built-in Color Picker for seamless visual grouping (e.g., House, Car, Subscriptions).
* **Advanced Filtering & Search:** Filter your bills instantly by Month, Year, Category, and Status (Paid/Unpaid).
* **Multi-language Support:** Complete integration for Greek (`el`) and English (`en`) using a custom localization Middleware that persists choices across sessions, complete with a clean text-based toggle (EN/EL) using Font Awesome icons in the Navbar.
* **Dynamic Dashboard Statistics:** Overview cards calculating Total Paid Amounts, Total Pending Amounts, and the exact count of Overdue Bills at the top of your page.
* **Water.css Integration:** A clean, responsive, and lightweight drop-in UI that automatically adapts to Dark/Light mode depending on the user's system preferences.

---

## 📸 Screenshots

### Main Dashboard (Bills Overview)
![Dashboard Screenshot](https://raw.githubusercontent.com/konstantina-baltzi/financial-control/main/public/screenshots/dashboard.png)

### Category Management & Language Toggle
![Categories & Lang Screenshot](https://raw.githubusercontent.com/konstantina-baltzi/financial-control/main/public/screenshots/categories.png)

---

## 🛠️ Tech Stack

* **Backend Framework:** Laravel 11 (PHP 8.2+)
* **Frontend Templating:** Blade Template Engine
* **Database:** MySQL / MariaDB
* **CSS Framework:** Water.css (Lightweight Drop-in Stylesheet)
* **Icons:** Font Awesome 6.4.0

---

## 🚀 Installation Guide

Follow these steps to set up and run the application locally:

### 1. Clone the Repository
```bash
git clone [https://github.com/konstantina-baltzi/financial-control.git](https://github.com/konstantina-baltzi/financial-control.git)
cd financial-control

2. Install Dependencies
Bash
composer install
3. Environment Configuration (.env)
Copy the .env.example file to create your own configuration:

Bash
cp .env.example .env
Open the .env file and configure your local database settings:

Απόσπασμα κώδικα
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=financial_control
DB_USERNAME=root
DB_PASSWORD=
4. Generate Application Key
Bash
php artisan key:generate
5. Run Database Migrations
Create all necessary tables (users, bills, categories) inside your database:

Bash
php artisan migrate
6. Start the Local Server
Bash
php artisan serve
Your application will be live and accessible at: http://127.0.0.1:8000

📂 Localization Structure
The multi-language system relies on JSON key-value translation files. If you want to modify text strings, you can find them here:

Plaintext
lang/
├── el.json  <-- Greek translation dictionary
└── en.json  <-- English translation dictionary
🔒 Security & Middlewares
The application ensures secure user isolation and persistence through:

Auth Middleware: Restricts access, ensuring views are only accessible to logged-in users.

SetLocaleMiddleware: Inspects the session on every incoming request and triggers app()->setLocale(), providing a seamless bilingual experience.

@csrf Protection: Mandatory Cross-Site Request Forgery tokens integrated across all operational forms (POST, PUT, DELETE).