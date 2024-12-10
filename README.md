# Project Name

Brief description of your project.

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB

## Installation

1. Clone the repository
   ```bash
   git clone [your-repository-url]
   cd [project-directory]
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install Node.js dependencies
   ```bash
   npm install
   ```

4. Create and configure environment file
   ```bash
   cp .env.example .env
   ```
   Then edit `.env` file with your database credentials and other configurations:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   QUEUE_CONNECTION=database
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Run database migrations
   ```bash
   php artisan migrate
   ```

7. Create queue tables
   ```bash
   php artisan queue:table
   php artisan queue:failed-table
   php artisan migrate
   ```

## Running the Application

You'll need to run these commands in separate terminal windows:

1. Start Laravel development server
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`

2. Compile assets and watch for changes
   ```bash
   npm run dev
   ```

3. Start the queue worker
   ```bash
   php artisan queue:work
   ```

## Queue Management Commands

### Monitoring and Management
