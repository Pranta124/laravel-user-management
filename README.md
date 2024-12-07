# Laravel User Management
A Laravel-based API for managing users, roles, and permissions with secure token-based authentication using Laravel Passport and Spatie Laravel Permission.
# Table of Contents
- [Requirements](#requirements)
- [Features](#features)
- [Installation Steps](#installation-steps)
- [Configuration](#configuration)
  - [Laravel Passport](#laravel-passport)
  - [Spatie Laravel Permission](#spatie-laravel-permission)
  - [Seed Role Permission](#seed-role-permission)
  - [Autoload File](#autoload-file)
- [Virtual Host Setup](#virtual-host-setup)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [License](#license)
## Requirements
- PHP 8.2+ 
- Composer
- Laravel 11.x+
- MySQL Database
- ext-sodium (or use `--ignore-platform-req=ext-sodium`)
## Features
* User Authentication: Secure token-based authentication using Laravel Passport.
* Role and Permission Management:
   - A user can have multiple roles.
   - A user can have multiple permissions, either directly assigned or inherited through roles.
   - A role can have multiple permissions.
* Permission Handling: Fine-grained access control powered by Spatie Laravel Permission.
* Scalable API: Designed for easy integration with other systems and extensibility for future requirements.
* Utilize the Repository Pattern: Follows the Repository Pattern for a clean separation of concerns, making the application scalable and testable.
* Follow PSR Standards: Adheres to PHP Standards Recommendations (PSR) for clean, consistent, and maintainable code.
## Installation Steps
1. **Clone the repository:**
   ```bash
   git clone https://github.com/Pranta124/laravel-user-management.git
2. **Install dependencies:**
   ```bash
   composer install
3. **Copy the example .env file:**
   ```bash
   cp .env.example .env
4. **Update your .env .** file with database credentials and application configuration.
5. **Generate the application key:**
   ```bash
   php artisan key:generate
6. **Run migrations:**
   ```bash
   php artisan migrate
## Configuration
## Laravel Passport
1. **Install the Passport package:**
   ```bash
   composer require laravel/passport --ignore-platform-req=ext-sodium
2. **Install Passport:**
   ```bash
   php artisan passport:install
3. **Publish Passport’s resources:**
   ```bash
   php artisan vendor:publish --provider="Laravel\Passport\PassportServiceProvider"
4. **Run database migrations:**
   ```bash
   php artisan migrate
5. **Passport key generate:**
   ```bash
   php artisan passport:keys
6. **Create Password Grant Client:**
   ```bash
   php artisan passport:client --password
   You'll get a Client ID and Client Secret. Add these to your .env file:
   OAUTH_CLIENT_ID=1
   OAUTH_CLIENT_SECRET=FhU64RmMUYD63HG1lDFYsOnQJOnf9jF8irB41H23
## Spatie Laravel Permission
1. **Install the package:**
   ```bash
   composer require spatie/laravel-permission --ignore-platform-req=ext-sodium
2. **Publish the package configuration:**
   ```bash
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
3. **Publish the package configuration:**
   ```bash
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
4. **Run database migrations:**
   ```bash
   php artisan migrate
## Seed Role Permission
1. **Run Those Seed:**
   ```bash
   php artisan db:seed --class=RolePermissionSeeder
   php artisan db:seed --class=UserRolePermissionSeeder
## Autoload File
1. **Regenerate the autoload files:**
   ```bash
   composer dump-autoload
## Virtual Host Setup
1. **Set up a virtual host to point to your Laravel project. Example configuration for Apache:**
   ```bash
   <VirtualHost *:80>
    ServerName user-management.backend
    DocumentRoot /path/to/laravel-user-management/public

    <Directory /path/to/laravel-user-management/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

2. **Add the virtual host to your system's /etc/hosts file:**
   ```bash
   127.0.0.1 user-management.backend

3. **Update your .env file with the virtual host URL:**
   ```bash
   env
   APP_URL=http://user-management.backend

4. **Restart your web server:**

## Usage
## Authentication
* Use the Password Grant Token client for authentication.
* Ensure requests include the following header:
  ```bash
   Accept: application/json
## API Collection Link
1. **You can access the complete Postman collection for this project using the link below:**
    - [API Documentation on Postman](https://documenter.getpostman.com/view/35136827/2sAYBbfA2b#53920490-e98d-416f-b16e-40b1c3648be9)

## License
* This project is open-source and available

