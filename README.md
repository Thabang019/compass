<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Insatllation Guide

Dependencies:

XAMPP
XAMPP provides an easy-to-install Apache-MySQL-PHP-PhpMyAdmin environment that is suitable for running the Laravel project locally. Download and install XAMPP from the official website: XAMPP Official Website

PHP Version:
Ensure that a compatible version of PHP is installed (recommended: PHP 7.2 or higher) to run the Laravel project. In the Git Bash terminal, run the following command: php -v

Composer:
Ensure that Composer is installed to manage the project's dependencies. If Composer is not already installed, you can download it from Composer's official website.

Node.js
Ensure that Node.js and npm are installed on the local machine. You can download and install Node.js from the official website:

Laravel Framework:
The project utilizes Laravel framework. Ensure that the local environment has Laravel installed. You can install Laravel using Composer by running the following command: composer global require laravel/installer

Git
Install Git to clone the project repository and manage version control. Git can be downloaded and installed from the official Git website:
Environment Setup:




Clone the Project Repository:
Clone the project repository from the current version control system (Git) to your local machine.

Install Dependencies:
Navigate to the project directory and run the following command to install the project dependencies using Composer by running the following command: composer install

Migrate Database:
Run the database migrations to create the necessary tables in the database by running the following command: php artisan migrate

Install Node.js Packages:
Navigate to the project directory using git and run the following command to install the necessary Node.js packages: npm install

Run Laravel Mix:
The project uses Laravel Mix for asset compilation (e.g., SCSS, JavaScript), run the following command to compile assets: npm run dev

Start the Development Server:
To start the development server, run the following command: php artisan serve