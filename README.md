<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Student Project Partners

## Description

Student Project Partners is a web application designed to help university students find and manage project partners for their courses. It streamlines the process of collaboration and enhances the academic experience by providing a platform for students to connect based on their courses, programs, and batches.

## Features

- User authentication (login and registration)
- Profile creation and management
- Course-specific partner search
- Partner request system
- Current partners overview
- Responsive design for various devices

## Tech Stack

- Laravel 10.x
- PHP 8.x
- MySQL
- Tailwind CSS
- Alpine.js (for interactive components)

## Prerequisites

- PHP 8.x
- Composer
- Node.js and npm
- MySQL

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/Hassnain-Ahmed/student-project-partners.git
   cd student-project-partners
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install and compile frontend dependencies:
   ```
   npm install
   npm run dev
   ```

4. Create a copy of the .env file:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Configure your database in the .env file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run database migrations:
   ```
   php artisan migrate
   ```

8. Serve the application:
   ```
   php artisan serve
   ```

## Usage

1. Register a new account or log in to an existing one.
2. Complete your profile by providing university, program, batch, and course information.
3. Browse available project partners for your courses.
4. Send partner requests to potential collaborators.
5. Accept or reject incoming partner requests.
6. View your current project partners for each course.

## Contributing

We welcome contributions to the Student Project Partners project. Please follow these steps to contribute:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.

## Contact

Hassnain Ahmed - dev.hassnain77@gmail.com

Project Link: https://github.com/Hassnain-Ahmed/student-project-partners.git
