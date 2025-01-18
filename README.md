# Project Name

Brief description of your project.

## Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
- [XAMPP](https://www.apachefriends.org/index.html)
- [Docker Desktop](https://docs.docker.com/desktop/setup/install/windows-install/)
- [Git](https://git-scm.com/downloads)
- [DBeaver](https://dbeaver.io/download/)

For setup instructions, you can also refer to this [tutorial video](https://www.youtube.com/watch?v=iBaM5LYgyPk&t=1375s).

## Installation

### Steps

1. Clone the repository
   ```bash
   git clone --single-branch -b dev https://github.com/Atlas-USV/USV_Schedulling.git
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

4. Set up Docker
   - Open Docker Desktop and log in or create an account.
   - Start Docker and run the following command:
     ```bash
     docker-compose up -d
     ```

5. Create and configure the environment file
   ```bash
   cp .env.example .env
   ```
   Then edit the `.env` file with your database credentials and other configurations:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   QUEUE_CONNECTION=database
   ```

6. Generate application key
   ```bash
   php artisan key:generate
   ```

7. Run database migrations
   ```bash
   php artisan migrate
   ```

8. Seed the database
   - Copy `subgrupe.php` to the `/storage` folder.
   - Run the seeder:
     ```bash
     php artisan db:seed
     ```

## Running the Application

1. Start Laravel development server
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

2. Compile assets and watch for changes
   ```bash
   npm run dev
   ```

3. Start the queue worker
   ```bash
   php artisan queue:work
   ```

## Additional Tools

- **DBeaver**: Use this to access and manage the database. Download it from [DBeaver](https://dbeaver.io/download/).
- **Visual Studio Code**: Open the project in a new folder and use the terminal within VSCode to execute commands.

## Queue Management Commands

### Monitoring and Management

- Monitor queues:
  ```bash
  php artisan queue:listen
  ```
- Retry failed jobs:
  ```bash
  php artisan queue:retry all
  ```

---

For any issues or troubleshooting, please refer to the [Laravel Documentation](https://laravel.com/docs) or the [Docker Documentation](https://docs.docker.com/).
