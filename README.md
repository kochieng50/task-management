Task Management Application
A full-stack task management application built with Laravel (backend) and Vue.js 3 (frontend) using MySQL as the database. This project implements RESTful APIs, authentication with Laravel Sanctum, and a responsive frontend with pagination, sorting, filtering, and error handling.
Setup Instructions
Backend (Laravel)

Clone the repository:git clone <repository-url>
cd task-management

Install dependencies:composer install

Copy .env.example to .env and configure MySQL:cp .env.example .env

Update .env with your MySQL credentials:DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

Generate application key:php artisan key:generate

Run migrations:php artisan migrate

Start the Laravel server:php artisan serve

Frontend (Vue.js)

Navigate to the frontend directory:cd task-management-frontend

Install dependencies:npm install

Start the Vue development server:npm run dev

API Documentation

Register: POST /api/register - Register a new user
Body: { name, email, password, password_confirmation }

Login: POST /api/login - Authenticate a user
Body: { email, password }

Logout: POST /api/logout - Log out a user (requires auth)
Tasks:
GET /api/tasks - List tasks (supports pagination, sorting, filtering by title/due_date)
POST /api/tasks - Create a task (requires auth)
GET /api/tasks/{id} - Show a task (requires auth)
PUT /api/tasks/{id} - Update a task (requires auth)
DELETE /api/tasks/{id} - Delete a task (requires auth)

Additional Decisions

Caching: Implemented caching for task listings using Laravel's Cache facade to improve performance.
Responsive Design: Used Tailwind CSS for a responsive UI that works on mobile, tablet, and desktop.
Error Handling: Both backend and frontend include comprehensive error handling with meaningful messages.
Authorization: Ensured users can only manage their own tasks using Sanctum's middleware.

Running the Application

Start the Laravel backend: php artisan serve
Start the Vue frontend: npm run dev
Access the application at http://localhost:5173 (or the Vite port).

Evaluation Criteria

Code Structure: Modular and maintainable with clear separation of concerns.
API Design: RESTful endpoints with proper validation and error handling.
Frontend UX/UI: Responsive design with intuitive navigation and feedback.
Authentication: Secure API authentication with Sanctum and route protection in Vue.
Performance: Optimized queries and caching for efficient data retrieval.
