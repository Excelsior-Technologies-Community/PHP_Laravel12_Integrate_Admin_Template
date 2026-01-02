# PHP_Laravel12_Integrate_Admin_Template

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" />
  <img src="https://img.shields.io/badge/Admin_Template-SB_Admin-0D6EFD?style=for-the-badge" />
  <img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/Platform-Windows_CMD-0078D6?style=for-the-badge&logo=windows&logoColor=white" />
  <img src="https://img.shields.io/badge/Status-Working_Successfully-success?style=for-the-badge" />
</p>

---

##  Overview

This project shows how to integrate an admin template into Laravel 12 with a **reusable Blade layout structure**.  
It is ideal for building **admin panels, dashboards, and back-office systems**.

The setup follows Laravel best practices and is easy to extend for real-world projects.

---

##  Features

-  Laravel 12 compatible
-  SB Admin (Bootstrap 5) UI integration
-  Reusable Blade layout system
-  Dashboard with cards & charts
-  Users listing with database data
-  Sidebar & top navigation included
-  No frontend build tools required
-  Easy to extend (Auth, Roles, CRUD, etc.)

---

##  Requirements

- PHP **8.2+**
- Laravel **12.x**
- Composer
- MySQL
- SB Admin (Bootstrap 5)

---

##  Database Configuration (`.env`)

Update your `.env` file with MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

```

---

##  Final Folder Structure

```text
public/
 └── theme/
     ├── css/
     ├── js/
     └── assets/

resources/views/
 ├── theme/
 │   ├── default.blade.php
 │   ├── header.blade.php
 │   ├── sidebar.blade.php
 │   └── footer.blade.php
 ├── dashboard.blade.php
 └── users.blade.php

app/Http/Controllers/
 └── UserController.php
```

---

## Step 1️: Install Laravel 12 (Optional)

```bash
composer create-project laravel/laravel example-app

```

---

## Step 2️: Download SB Admin Template

1. Visit **Start Bootstrap – SB Admin**
2. Download **SB Admin (Bootstrap 5)**
3. Extract the ZIP file
4. Copy the following folders into Laravel:

```text
public/theme/css
public/theme/js
public/theme/assets
```

📌 Laravel loads static files only from the `public/` directory.

---

## Step 3️: Create Admin Layout Files

Create folder:

```text
resources/views/theme
```

---

### `resources/views/theme/default.blade.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard - SB Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('theme/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="sb-nav-fixed">

@include('theme.header')

<div id="layoutSidenav">

    @include('theme.sidebar')

    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>

        @include('theme.footer')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('theme/js/scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script src="{{ asset('theme/assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('theme/assets/demo/chart-bar-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script src="{{ asset('theme/js/datatables-simple-demo.js') }}"></script>

</body>
</html>
```

---

### `resources/views/theme/header.blade.php`

```blade
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="/dashboard">SB Admin</a>

    <button class="btn btn-link btn-sm" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
```

---

### `resources/views/theme/sidebar.blade.php`

```blade
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="/users">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Users
                </a>

            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Admin
        </div>
    </nav>
</div>
```

---

### `resources/views/theme/footer.blade.php`

```blade
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between small">
            <div class="text-muted">© 2024 Your Website</div>
            <div>
                <a href="#">Privacy</a> · <a href="#">Terms</a>
            </div>
        </div>
    </div>
</footer>
```

---

## Step 4️: Create Routes

`routes/web.php`

```php
use App\Http\Controllers\UserController;

Route::get('/dashboard', [UserController::class, 'dashboard']);
Route::get('/users', [UserController::class, 'users']);
```

---

## Step 5️: Create Controller

```bash
php artisan make:controller UserController
```
app/Http/Controllers/UserController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('users', compact('users'));
    }
}
```

---

## Step 6️: Dashboard Page

`resources/views/dashboard.blade.php`

```blade
@extends('theme.default')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Users</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6"><canvas id="myAreaChart"></canvas></div>
        <div class="col-xl-6"><canvas id="myBarChart"></canvas></div>
    </div>

</div>
@endsection
```

---

## Step 7️: Users Page

`resources/views/users.blade.php`

```blade
@extends('theme.default')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4">Users</h1>

    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
```

---

## Step 8️: Create Dummy Data

```bash
php artisan tinker
```

```php
User::factory()->count(30)->create();
```

---

## Step 9️: Run Application

```bash
php artisan serve
```

Visit:

```
http://localhost:8000/dashboard
```
<img width="1919" height="927" alt="Screenshot 2026-01-02 151513" src="https://github.com/user-attachments/assets/bd2ffdb1-0d31-43ed-b982-5e4de7070780" />

```
http://localhost:8000/users
```
<img width="1908" height="999" alt="Screenshot 2026-01-02 151525" src="https://github.com/user-attachments/assets/375d2c10-75fc-4305-bac0-4160d381be3d" />

---

## ✅ Final Result

* SB Admin successfully integrated with Laravel 12
* Blade-based reusable admin layout
* Dashboard and Users pages working
* Bootstrap 5 admin UI ready

---


