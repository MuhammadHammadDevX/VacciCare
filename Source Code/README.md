# VacciCare - Vaccination Management System (Laravel)

A comprehensive vaccination management system migrated from Core PHP to Laravel 12. This application manages child vaccinations, hospital registrations, vaccine scheduling, and vaccination tracking across three user portals: **Parent**, **Admin**, and **Hospital**.

---

## Table of Contents

1. [System Requirements](#system-requirements)
2. [Installation Guide](#installation-guide)
3. [Database Configuration](#database-configuration)
4. [Running Migrations](#running-migrations)
5. [Starting the Application](#starting-the-application)
6. [Application Architecture](#application-architecture)
7. [Module Summary](#module-summary)
8. [Route Reference](#route-reference)
9. [Testing](#testing)
10. [Project Structure](#project-structure)

---

## System Requirements

- **PHP** >= 8.2
- **Composer** >= 2.x
- **MySQL** >= 5.7 / MariaDB >= 10.3
- **Node.js** >= 18 (optional, for Vite asset compilation)
- **Laravel** 12.x

---

## Installation Guide

### Step 1: Clone / Copy the Project

Copy the `laravel-app` folder to your desired location.

### Step 2: Install PHP Dependencies

```bash
cd laravel-app
composer install
```

### Step 3: Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### Step 4: Configure `.env`

Open `.env` and update the database settings to match your MySQL server:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307          # Change to 3306 if your MySQL uses the default port
DB_DATABASE=vaccicare
DB_USERNAME=root
DB_PASSWORD=          # Enter your MySQL password if set
```

### Step 5: Create the Database

If the database doesn't exist yet, create it via MySQL:

```sql
CREATE DATABASE IF NOT EXISTS vaccicare;
```

If you have the original SQL dump (`Database/vaccicare (7).sql`), import it first:

```bash
mysql -u root -p vaccicare < "Database/vaccicare (7).sql"
```

### Step 6: Run Migrations

```bash
php artisan migrate
```

> **Note:** If the database already has tables from the original PHP application, use `--pretend` first to see what would change, then run without it. The migrations are designed to be compatible with the existing schema.

### Step 7: Seed the Database (Optional)

Only run this if you need sample data and the database is empty:

```bash
php artisan db:seed
```

### Step 8: Start the Application

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## Database Configuration

This application uses **MySQL** exclusively. The database `vaccicare` contains the following tables:

| Table | Description |
|-------|-------------|
| `users` | System users (parents, vaccinators, admins) |
| `parents` | Parent profiles linked to user accounts |
| `hospitals` | Hospital directory with location & status |
| `hospital_users` | Hospital login accounts (separate auth guard) |
| `children` | Children registered under parents |
| `vaccines` | Master vaccine catalog |
| `hospital_vaccines` | Vaccines offered by each hospital |
| `vaccinators` | Vaccination staff per hospital |
| `parent_requests` | Vaccination appointment requests |
| `bookings` | Confirmed vaccination bookings |
| `vaccinations` | Completed vaccination records |
| `notifications` | System notifications |
| `sessions` | Laravel session storage |

---

## Application Architecture

### MVC Structure

- **Models** (12): `User`, `ParentModel`, `Hospital`, `HospitalUser`, `Child`, `Vaccine`, `HospitalVaccine`, `Vaccinator`, `ParentRequest`, `Booking`, `Vaccination`, `Notification`
- **Controllers** (6): `HomeController`, `AuthController`, `ParentDashboardController`, `AdminDashboardController`, `HospitalDashboardController`, `Controller`
- **Middleware** (3): `EnsureAdmin`, `EnsureParent`, `EnsureHospital`
- **Views** (47 Blade templates): Layouts, public pages, auth, parent, admin, hospital

### Authentication

- **Parent/Admin**: Uses the `web` guard (authenticates against `users` table)
- **Hospital**: Uses the `hospital` guard (authenticates against `hospital_users` table)
- Multi-guard configuration in `config/auth.php`

### Session Variables

The application maintains session compatibility with the original PHP app:
- `user_id`, `parent_id`, `user_name`, `user_email`, `role` (parent/admin)
- `hospital_id`, `hospital_name`, `hospital_email` (hospital)

---

## Module Summary

### Public Pages (3 views)
| Page | Route | View |
|------|-------|------|
| Homepage | `/` | `home.index` |
| Vaccines Info | `/vaccines` | `home.vaccines` |
| Appointment Info | `/appointment` | `home.appointment` |

### Authentication (4 views)
| Page | Route | View |
|------|-------|------|
| Sign In | `/signin` | `auth.signin` |
| Register Select | `/register-select` | `auth.register-select` |
| Register Parent | `/register` | `auth.register-parent` |
| Logout | `/logout` | `auth.logout` |

### Parent Portal (9 views)
| Page | Route | View |
|------|-------|------|
| Dashboard | `/parent/dashboard` | `parent.dashboard` |
| Profile | `/parent/profile` | `parent.profile` |
| Edit Profile | `/parent/edit-profile` | `parent.edit-profile` |
| My Children | `/parent/my-children` | `parent.children` |
| Edit Child | `/parent/edit-child/{id}` | `parent.edit-child` |
| Schedule | `/parent/vaccination-schedule` | `parent.schedule` |
| Book Hospital | `/parent/book-hospital` | `parent.book-hospital` |
| Requests | `/parent/request-hospital` | `parent.requests` |
| Report | `/parent/vaccination-report` | `parent.report` |

### Admin Portal (16 views)
| Page | Route | View |
|------|-------|------|
| Login | `/admin/login` | `admin.login` |
| Create Admin | `/admin/create-admin` | `admin.create-admin` |
| Dashboard | `/admin/dashboard` | `admin.dashboard` |
| Profile | `/admin/profile` | `admin.profile` |
| Edit Profile | `/admin/edit-profile` | `admin.edit-profile` |
| Children List | `/admin/children` | `admin.children` |
| Child Details | `/admin/child-details/{id}` | `admin.child-details` |
| Hospital List | `/admin/hospitals` | `admin.hospital-list` |
| Add Hospital | `/admin/add-hospital` | `admin.add-hospital` |
| View Hospital | `/admin/view-hospital/{id}` | `admin.view-hospital` |
| Edit Hospital | `/admin/edit-hospital/{id}` | `admin.edit-hospital` |
| Vaccine List | `/admin/vaccine-list` | `admin.vaccine-list` |
| Parent Requests | `/admin/parent-requests` | `admin.parent-requests` |
| Booking Details | `/admin/booking-details` | `admin.booking-details` |
| Vaccinations by Date | `/admin/vaccinations-date` | `admin.vaccinations-date` |
| Vaccination Report | `/admin/vaccination-report` | `admin.vaccination-report` |

### Hospital Portal (10 views)
| Page | Route | View |
|------|-------|------|
| Login | `/hospital/login` | `hospital.login` |
| Register | `/hospital/register` | `hospital.register` |
| Dashboard | `/hospital/dashboard` | `hospital.dashboard` |
| Profile | `/hospital/profile` | `hospital.profile` |
| Edit Profile | `/hospital/edit-profile` | `hospital.edit-profile` |
| Appointments | `/hospital/appointments` | `hospital.appointments` |
| Vaccine Status | `/hospital/vaccine-status` | `hospital.vaccine-status` |
| Add Vaccine | `/hospital/add-vaccine` | `hospital.add-vaccine` |
| All Vaccines | `/hospital/all-vaccines` | `hospital.all-vaccines` |
| Vaccinators | `/hospital/vaccinators` | `hospital.vaccinators` |

### Layouts (4 templates)
- `layouts.app` — Public pages layout
- `layouts.parent` — Parent dashboard layout with sidebar
- `layouts.admin` — Admin dashboard layout with sidebar
- `layouts.hospital` — Hospital dashboard layout with sidebar

---

## Route Reference

The application registers **129 routes** including legacy `.php` aliases for backward compatibility. Run `php artisan route:list` for the full list.

### Legacy PHP Compatibility

All original `.php` URLs are supported via route aliases:
- `signin.php` → `/signin`
- `parent_dashboard.php` → `/parent/dashboard`
- `admin-dashboard.php` → `/admin/dashboard`
- `hospital-dashboard.php` → `/hospital/dashboard`
- And all other original PHP file paths

---

## Testing

### Run All Tests

```bash
php artisan test
```

### Test Files

| Test File | Tests | Description |
|-----------|-------|-------------|
| `PublicRoutesTest` | 11 | Homepage, vaccines, signin, register, admin/hospital login pages, legacy routes |
| `AuthenticationTest` | 9 | Login validation, registration validation, logout, authentication guards |
| `ProtectedRoutesTest` | 15 | All protected routes redirect unauthenticated users |

---

## Project Structure

```
laravel-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── HomeController.php
│   │   │   ├── Admin/AdminDashboardController.php
│   │   │   ├── Hospital/HospitalDashboardController.php
│   │   │   └── Parent/ParentDashboardController.php
│   │   └── Middleware/
│   │       ├── EnsureAdmin.php
│   │       ├── EnsureHospital.php
│   │       └── EnsureParent.php
│   └── Models/
│       ├── Booking.php
│       ├── Child.php
│       ├── Hospital.php
│       ├── HospitalUser.php
│       ├── HospitalVaccine.php
│       ├── Notification.php
│       ├── ParentModel.php
│       ├── ParentRequest.php
│       ├── User.php
│       ├── Vaccination.php
│       ├── Vaccinator.php
│       └── Vaccine.php
├── config/
│   └── auth.php              # Multi-guard config (web + hospital)
├── database/
│   ├── migrations/           # 15 migration files
│   └── seeders/
│       └── DatabaseSeeder.php
├── public/
│   ├── css/                  # All original CSS files
│   ├── js/                   # All original JS files
│   └── images/               # All original images & assets
├── resources/
│   └── views/
│       ├── layouts/          # 4 layout templates
│       ├── home/             # 3 public views
│       ├── auth/             # 4 auth views
│       ├── parent/           # 9 parent views
│       ├── admin/            # 16 admin views
│       └── hospital/         # 10 hospital views
├── routes/
│   └── web.php               # 129 routes
├── tests/
│   └── Feature/
│       ├── PublicRoutesTest.php
│       ├── AuthenticationTest.php
│       └── ProtectedRoutesTest.php
├── .env                      # MySQL configuration
├── .env.example              # Template configuration
└── README.md
```

---

## Security Features

- **CSRF Protection**: All forms include `@csrf` tokens
- **Password Hashing**: Uses Laravel's `Hash::make()` (bcrypt)
- **SQL Injection Prevention**: All queries use Eloquent ORM / Query Builder
- **XSS Protection**: All output uses Blade `{{ }}` escaping
- **Authentication Guards**: Multi-guard system with session-based auth
- **Middleware Protection**: Role-based access control on all dashboard routes
- **Input Validation**: Server-side validation on all form submissions

---

## Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check `.env` for correct `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- The original project used port **3307** — adjust if your MySQL uses **3306**

### Missing Assets (CSS/JS/Images)
- Ensure the `public/css/`, `public/js/`, and `public/images/` directories contain the original assets
- Run `php artisan storage:link` if storage links are needed

### Session Issues
- Clear sessions: `php artisan session:clear` or truncate the `sessions` table
- Clear all caches: `php artisan optimize:clear`

---

## Migration from Core PHP

This application was migrated from a Core PHP (procedural) codebase to Laravel 12 with:

- ✅ 100% feature preservation
- ✅ Original UI/UX maintained
- ✅ All database tables and relationships preserved
- ✅ MySQL database retained (no database engine change)
- ✅ All business logic ported to Controllers/Models
- ✅ All frontend converted to Blade templates
- ✅ Legacy URL compatibility maintained
- ✅ Proper Laravel security standards implemented
