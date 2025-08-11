# 🎓 Scholarship Management System API

This is a Laravel 12-based RESTful API for managing scholarships. The system supports two types of users: **Admins** and **Students**. It allows admins to create and manage scholarships while students can register, view, and apply for them.

The project follows a **Repository-Service Pattern** and uses **Laravel Sanctum** for token-based authentication.
also spatie role and permission is used.

---

## 📌 Features

### 🧑‍🎓 Student
- Register and login
- Token-based authentication via Sanctum
- View available scholarships
- Apply for scholarships
- Upload documents for their applications
- View their own application logs

🔒 **Restrictions**
- Cannot manage or modify scholarships
- Cannot apply on behalf of other students
- Cannot upload documents for other users
- Cannot access others applications.

---

### 👨‍💼 Admin
- Create, update, delete, and view scholarships
- View all student applications
- Update application statuses

---

### 🚧 Upcoming Features
- Email notifications
- Enhanced application filters and reporting
- Cost and award related module (left for dev)

---

## ⚙️ How to Run the Project

1. **Clone the repository**
   ```bash
   git clone the project
   cd /
2. **Install dependencies**
   ```bash
   composer install
3. **Copy env**
   ```bash
   cp .env.example .env
4. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
5. **Run Application**
   ```bash
   php artisan serve

## 🧱 Project Structure

- app/ Events/         → Handles events (e.g. application document created) (for now)
-  /Exceptions/        → Custom API exception handling
-  /Helpers/           → Reusable utility functions (file upload, response, email)
-  /Http/
-  /Controllers/       → Thin controllers
- -  - Api/
- -  - Auth/   → Auth controllers (login, register)
- -  -  Logs/   → Logs-related APIs
- -  -     └── ...     → Other API endpoints
-  /Middleware/     → Role-based access control using Spatie
-  /Requests/          → Form validation and access protection

-  /Jobs → For handle background job process. (Application documet handle for now)
-  /Listeners → Listen to the notifications. (Application documet handle for now)
-  /Mail  → For sending emails (mailable).
-  /Models  → Database models. (with observer models as well)
-  /Obsevers  → For application logs. (this stage only application create logs)
-  /Repository  → For repositor pattern for access data layer.
-  /Services  → Handle business layer logincs.

- Others same as laravel.

