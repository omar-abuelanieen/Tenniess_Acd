# Tennis Academy Management System API

## Overview

A Laravel RESTful API for managing a Tennis Academy. The system handles users, roles, coaches, players, training sessions, attendance tracking, and subscriptions.

## Features

* User Management
* Role Management
* Coach Management
* Player Management
* Training Session Management
* Attendance Tracking
* Subscription Management
* Soft Deletes & Restore
* Request Validation
* Service Layer Architecture
* Laravel Sanctum Authentication

## Technologies Used

* PHP 8+
* Laravel 12
* MySQL
* Laravel Sanctum
* Postman

## Installation

Clone the repository:

```bash
git clone https://github.com/your-username/your-repository.git
```

Navigate to the project:

```bash
cd your-repository
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure database credentials inside `.env`

Run migrations:

```bash
php artisan migrate
```

Start the server:

```bash
php artisan serve
```

## Authentication

The API uses Laravel Sanctum for authentication.

### Login

```http
POST /api/login
```

### Logout

```http
POST /api/logout
```

## Main Resources

### Users

* GET /api/users
* POST /api/users
* GET /api/users/{id}
* PUT /api/users/{id}
* DELETE /api/users/{id}

### Roles

* GET /api/roles
* POST /api/roles
* PUT /api/roles/{id}
* DELETE /api/roles/{id}

### Coaches

* GET /api/coaches
* POST /api/coaches
* PUT /api/coaches/{id}
* DELETE /api/coaches/{id}

### Players

* GET /api/players
* POST /api/players
* PUT /api/players/{id}
* DELETE /api/players/{id}

### Sessions

* GET /api/sessions
* POST /api/sessions
* PUT /api/sessions/{id}
* DELETE /api/sessions/{id}

### Attendance

* GET /api/attendances
* POST /api/attendances
* PUT /api/attendances/{id}
* DELETE /api/attendances/{id}

### Subscriptions

* GET /api/subscriptions
* POST /api/subscriptions
* PUT /api/subscriptions/{id}
* DELETE /api/subscriptions/{id}
* PATCH /api/subscriptions/{id}/activate
* PATCH /api/subscriptions/{id}/cancel
* PATCH /api/subscriptions/{id}/freeze

## Project Structure

* Controllers
* Models
* Form Requests
* Services
* Helpers
* Migrations

## API Response Format

Success Response

```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {}
}
```

Error Response

```json
{
    "success": false,
    "message": "Something went wrong"
}
```

## Author
omar abuelanieen
Developed as a Laravel API project for Tennis Academy Management.
