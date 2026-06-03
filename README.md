# Medical Appointment Manager

A Laravel 12 application for managing medical appointments with authentication, role-based access, and a complete CRUD system.

## Features

- User Authentication (Login/Register)
- Role-based Access (Patient/Doctor)
- Full Appointment Management (Create, Read, Update, Delete)
- Service Management
- Bootstrap 5 Responsive Design
- REST API Endpoints
- Internationalization (EN/FR)

## Requirements

- PHP 8.3+
- Composer
- Node.js & npm
- MySQL

## Installation

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure Database

Update `.env` with your MySQL credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical_appointments
DB_USERNAME=root
DB_PASSWORD=
```

Create the database:
```bash
mysql -u root -e "CREATE DATABASE medical_appointments;"
```

### 4. Run Migrations & Seeding
```bash
php artisan migrate
php artisan db:seed
```

### 5. Start Development Servers

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

Access the application at `http://localhost:8000`

## Database Schema

### Users
- id, name, email, password, role (patient|doctor), timestamps

### Services
- id, name, description, price, timestamps

### Appointments
- id, patient_id, doctor_id, service_id, appointment_date, status (pending|confirmed|cancelled), notes, timestamps

## Test Credentials

After seeding, all test users have password: `password`

View users:
```bash
php artisan tinker
>>> App\Models\User::all(['id', 'name', 'email', 'role']);
>>> exit
```

## Project Structure

```
app/
  ├── Models/              (User, Appointment, Service)
  ├── Http/
  │   ├── Controllers/     (Dashboard, Appointment)
  │   └── Policies/        (Authorization)
  └── Providers/

database/
  ├── migrations/
  ├── factories/
  └── seeders/

resources/
  ├── views/               (Blade templates)
  └── lang/                (Translations - EN/FR)

routes/
  ├── web.php
  └── api.php
```

## API Endpoints

- `GET /api/appointments` - List appointments
- `POST /api/appointments` - Create appointment

## Troubleshooting

### Database Connection Error
```bash
# Verify MySQL is running and credentials are correct in .env
php artisan migrate
```

### View Not Found
```bash
php artisan view:clear
php artisan cache:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

## Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templating](https://laravel.com/docs/blade)

## License

This project is created for OFPPT training purposes.
