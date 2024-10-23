# Laravel 11 & Vue 3 Setup with Tailwind CSS

## Table of Contents

-   [Introduction](#introduction)
-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Running the Application](#running-the-application)
-   [Project Structure](#project-structure)
-   [Built With](#built-with)
-   [Contributing](#contributing)
-   [License](#license)

## Introduction

This project is a simple web application built using Laravel 11 as the backend framework and Vue 3 for the frontend, styled with Tailwind CSS. It aims to provide a seamless development experience and a responsive user interface.

## Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP 8.0 or higher
-   Composer
-   Node.js (16.x or higher)
-   npm or Yarn
-   MySQL or another compatible database

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/umair-afzal-uat/laravel-vue.git
    cd your-repo-name
    ```

2. **Install backend dependencies**

    ```bash
    composer install
    ```

3. **Copy the `.env.example` file to `.env`**

    ```bash
    cp .env.example .env
    ```

4. **Generate an application key**

    ```bash
    php artisan key:generate
    ```

5. **Set up your database**: Configure your database settings in the `.env` file.

6. **Run migrations** (if applicable)

    ```bash
    php artisan migrate
    ```

7. **Install frontend dependencies**

    ```bash
    npm install
    ```

8. **Build assets**
    ```bash
    npm run build
    ```

## Configuration

-   Ensure you configure your database connection in the `.env` file.
-   Customize any other environment variables as needed.

## Running the Application

You can run the Laravel development server using:

```bash
php artisan serve
```

And for the Vue.js frontend, you can run:

```bash
npm run dev
```

Access your application at `http://localhost:8000`.

## Project Structure

```
your-repo-name/
├── app/                # Laravel application logic
├── bootstrap/          # Laravel bootstrap files
├── config/             # Configuration files
├── database/           # Database migrations and seeds
├── resources/          # Frontend assets (views, JS, CSS)
│   ├── js/             # Vue components
│   └── css/            # Tailwind CSS styles
├── routes/             # Route definitions
└── tests/              # Test files
```

## Built With

-   [Laravel 11](https://laravel.com) - The PHP framework for web artisans
-   [Vue 3](https://vuejs.org) - The progressive JavaScript framework
-   [Tailwind CSS](https://tailwindcss.com) - A utility-first CSS framework

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
