# Quotes Application

This is a Laravel application that fetches quotes from an external API and stores them in a database. The application provides endpoints to retrieve and store quotes.

## Prerequisites

Before setting up the application, ensure you have the following installed:

- PHP (>= 8.0)
- Composer
- Laravel CLI
- MySQL or any other supported database
- Node.js and NPM (for frontend dependencies, if applicable)

## Setup

Follow these steps to set up the application:

1. **Clone the repository:**

    ```sh
    git clone https://github.com/yourusername/quotes-app.git
    cd quotes-app
    ```

2. **Install PHP dependencies:**

    ```sh
    composer install
    ```

3. **Copy the `.env` file and set up environment variables:**

    ```sh
    cp .env.example .env
    ```

    Open the `.env` file and update the database credentials and other necessary configurations:

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=quotes_db
    DB_USERNAME=root
    DB_PASSWORD=password

    API_TOKEN=your_actual_api_token_here
    ```

4. **Generate application key:**

    ```sh
    php artisan key:generate
    ```

5. **Run database migrations:**

    ```sh
    php artisan migrate
    ```


## Running the Application

Start the local development server:

```sh
php artisan serve 