# Laravel User Management
A Laravel-based API for managing users, roles, and permissions with secure token-based authentication using Laravel Passport and Spatie Laravel Permission.
# Table of Contents
- [Features](#features)
- [Installation Steps](#installation-steps)
- [Configuration](#configuration)
  - [Laravel Passport](#laravel-passport)
  - [Spatie Laravel Permission](#spatie-laravel-permission)
- [Virtual Host Setup](#virtual-host-setup)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [License](#license)
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
1. Clone the repository:
   ```bash
   git clone https://github.com/Pranta124/laravel-user-management.git
2. Install dependencies:
  ```bash
    composer install
3. Copy the example .env file:
     ```bash
    cp .env.example .env
4. Update your .env file with database credentials and application configuration.
5. Generate the application key:
     ```bash
    php artisan key:generate
6. Run migrations:
     ```bash
    php artisan migrate

    



