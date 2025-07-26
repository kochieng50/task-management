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

Frontend Application Structure (Vue.js)
task-management/
├── public/
│ ├── index.html # Main HTML file for Vue.js SPA
│ └── favicon.ico # Favicon
├── src/
│ ├── assets/ # Static assets (images, styles, etc.)
│ │ ├── logo.png # Application logo
│ │ └── styles.css # Global CSS (if not using inline styles)
│ ├── components/ # Reusable Vue components
│ │ ├── Navbar.vue # Navigation bar with user profile and logout
│ │ └── Sidebar.vue # Sidebar with Dashboard and Tasks links
│ ├── views/ # Page-level components (route-specific)
│ │ ├── Dashboard.vue # Dashboard page with task stats and filters
│ │ ├── Tasks.vue # Tasks list page with filters and actions
│ │ ├── TaskCreate.vue # Form to create a new task
│ │ ├── TaskEdit.vue # Form to edit an existing task
│ │ ├── Login.vue # Login page
│ │ ├── Register.vue # Registration page
│ │ └── ForgotPassword.vue # Forgot password page
│ ├── router/
│ │ └── index.js # Vue Router configuration
│ ├── services/
│ │ └── api.js # Axios or fetch setup for API calls
│ ├── App.vue # Root Vue component
│ ├── main.js # Entry point for Vue.js app
│ └── store/ # Vuex or Pinia store (optional)
│ └── index.js # State management (if used)
├── .gitignore # Git ignore file (node_modules/, dist/, etc.)
├── package.json # Node.js dependencies and scripts
├── vite.config.js # Vite configuration (or vue.config.js for Vue CLI)
└── README.md # Project documentation

task-management-backend/
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ │ ├── Auth/
│ │ │ │ ├── LoginController.php # Handles POST /login
│ │ │ │ ├── RegisterController.php # Handles POST /register
│ │ │ │ └── ForgotPasswordController.php # Handles POST /forgot-password
│ │ │ ├── TaskController.php # Handles /tasks CRUD
│ │ │ └── UserController.php # Handles /user endpoint
│ │ ├── Middleware/
│ │ │ └── Authenticate.php # Sanctum authentication middleware
│ │ └── Requests/
│ │ ├── TaskRequest.php # Validation for task CRUD
│ │ ├── LoginRequest.php # Validation for login
│ │ └── RegisterRequest.php # Validation for registration
│ ├── Models/
│ │ ├── User.php # User model with name, email, avatar_url
│ │ └── Task.php # Task model with title, description, etc.
│ └── Providers/
│ └── AuthServiceProvider.php # Authentication policies
├── config/
│ ├── app.php # General app configuration
│ ├── auth.php # Sanctum configuration
│ └── sanctum.php # Sanctum-specific settings
├── database/
│ ├── migrations/
│ │ ├── 2023_01_01_000001_create_users_table.php # Users table
│ │ └── 2023_01_01_000002_create_tasks_table.php # Tasks table
│ ├── seeders/
│ │ └── DatabaseSeeder.php # Seed initial data
│ └── factories/
│ ├── UserFactory.php # User factory for testing
│ └── TaskFactory.php # Task factory for testing
├── routes/
│ ├── api.php # API routes for /user, /tasks, etc.
│ └── web.php # Optional web routes (if needed)
├── .env # Environment variables (DB, Sanctum)
├── .gitignore # Ignores vendor/, .env, etc.
├── composer.json # PHP dependencies
├── artisan # Laravel CLI
└── README.md # Backend documentation
