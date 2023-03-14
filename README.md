# Simple order checkout application with laravel
Simple order payment system using the paystar gateway (this project was only for practice)

## Getting Started

    Prerequisites:
    Docker Desktop installed on your local machine
1. git clone https://github.com/alipaz/simple-payment-system.git
2. Navigate to the project directory
3. Copy the .env.example file and rename it to .env:
    ``` 
    cp .env.example .env
    ```
4. Start the Docker containers:
    ``` 
    ./vendor/bin/sail up -d
    ```
5. Generate key
     ``` 
    ./vendor/bin/sail php artisan key:generate
    ```
6. Run the database migrations and seed the database:
     ``` 
    ./vendor/bin/sail php artisan key:generate
    ```
7. The application should now be running at 
 ``` 
 http://localhost:8084/
 ```
 ### Paying attention, this application has auth check, but for more convenience, seeder is used and it does not need to create an account and login.
