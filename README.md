# Attendance System

## Getting Started

This project is an Attendance System built with Laravel.
copy .env.example to .env file 

### Prerequisites
- PHP >= 8.3
- Composer
- Docker

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/Hassan-Shahriar-1/attendence-system.git
   cd attendence-system
   ```
2. Build and run the Docker containers:
    ```bash
    docker compose up --build -d
    ```

### After containers are up, run the following:
  ```bash
  
    # Enter PHP container and install PHP dependencies
    docker compose exec -it php /bin/bash
    composer install
    exit
    
    # Install Node dependencies
    docker compose run --rm node npm i
    
    # Clear and optimize Laravel
    docker compose exec -it php /bin/bash
    php artisan optimize:clear
    php artisan key:generate
    php artisan migrate:fresh --seed
    exit
```


### Usage
- Access the application at `http://localhost` after the containers are up and running.

### License
This project is licensed under the MIT License.

### Test Accounts

#### Admin Account
- Email: `admin@example.com`
- Password: `password`

#### Teacher Account
- Email: `teacher@example.com`
- Password: `password`

> Note: Update these credentials in your `.env` file or database seeding configuration as needed.
