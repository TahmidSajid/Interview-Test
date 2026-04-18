# Laravel Task Management API (Passport Auth)


## 📌 Project Overview
This is a Laravel 12 REST API for task management with authentication using Laravel Passport.


Requirements
1. PHP v8.3.28

## ⚙️ Setup Instructions
1. git clone https://github.com/TahmidSajid/Interview-Test
2. cd Interview-Test
3. composer install
4. cp .env.example .env
5. php artisan key:generate
6. configure database [DB_DATABASE=task_manager, DB_USERNAME=root, DB_PASSWORD=]
7. php artisan migrate:fresh --seed
8. php artisan passport:client --personal

AND in another terminal:
1. npm install
2. npm run build
