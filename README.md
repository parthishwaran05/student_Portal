<h1>Student Portal - Laravel Project</h1>

<h2>Learning laravel DAY 1 </h2>
Project Overview
A Laravel-based Student Portal application with dynamic content management and professional UI design.

<h3>What I've Completed</h3>
🏗️ Project Structure
Laravel 10 project setup with proper MVC architecture

Environment-based configuration for dynamic app naming

Blade templating system with layout inheritance

# Routing & Controllers
HomeController & AboutController for page handling

Named routes (home and about) for clean URL generation

RESTful routing structure

# Frontend Implementation
Master layout (layouts/app.blade.php) with Bootstrap 5

Header partial with dynamic navigation and active state highlighting

Footer partial with copyright and dynamic year display

Home page with feature cards and call-to-action sections

About page with mission statement and contact information

# Key Features
Dynamic App Name from .env configuration

Responsive Design using Bootstrap 5

Partial Views for reusable components

Environment Variables for easy customization

Professional UI with consistent branding

# File Structure Created
<pre>
student_portal/
├── routes/web.php
├── app/Http/Controllers/
│   ├── HomeController.php
│   └── AboutController.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── partials/
│   │   ├── header.blade.php
│   │   └── footer.blade.php
│   ├── home.blade.php
│   └── about.blade.php
└── .env (updated)
</pre>
# How to Run
bash
# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Start development server
php artisan serve
Visit http://localhost:8000 to see the Student Portal in action!

# Dynamic Configuration
The application name is dynamically loaded from .env file:

App name displays in header navigation

App name appears in page titles

Footer shows dynamic app name with copyright
