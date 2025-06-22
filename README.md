# Web Chat Application Backend Project 3389

This project is a **full-stack backend application** developed as part of a thesis at University American College Skopje.  
It is built with Laravel 8 and designed to handle real-time communication (via sockets) and robust database operations.  
While this repository covers the backend and socket server, there is a separate repository for the web (frontend) application:

👉 **Frontend repository:** [https://github.com/oomeryuce/chat-app-web](https://github.com/oomeryuce/chat-app-web)


## Table of Contents

* [Features](#features)
* [Installation](#installation)
* [Development](#development)
* [Configuration](#configuration)
* [Scripts](#scripts)
* [Packages](#packages)
* [License](#license)

---

## Features

* **Laravel 8 Framework**
* **RESTful API Support**
* **JWT & OAuth Authentication** (Sanctum, Passport)
* **Real-time broadcasting (Laravel Echo & Echo Server)**
* **Swagger/OpenAPI Documentation** (`l5-swagger`)
* **Frontend:**

  * Modern JS/CSS bundled with Laravel Mix
  * Axios for easy API consumption
  * Lodash & PostCSS integration
* **Comprehensive Testing:** PHPUnit, Mockery, Faker

---

## Installation

### 1. Clone the Repository

```bash
git clone oomeryuce/chat-app-api
cd chat-app-api
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node.js Dependencies

```bash
npm install
```

### 4. Create Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure the Database

Edit your `.env` file and update database credentials as needed.

---

## Development

### Start the Development Server

```bash
php artisan serve
```

### Build Frontend Assets (Development)

```bash
npm run dev
```

### Watch Files Automatically

```bash
npm run watch
```

### Hot Reload

```bash
npm run hot
```

### Production Build

```bash
npm run prod
```

---

## Configuration

* **Swagger Documentation:**
  Access auto-generated API docs at `/api/documentation`.
  (Swagger settings: `config/l5-swagger.php`)

* **Real-time Broadcasting:**
  Use `laravel-echo-server` for websocket broadcasting.
  For setup and configuration, check out the [Laravel Echo Server documentation](https://github.com/tlaverdure/laravel-echo-server).

* **Authentication:**
  API authentication can be handled via JWT, Passport, or Sanctum.

---

## Scripts

**PHP Artisan**

* `php artisan migrate` – Run database migrations
* `php artisan db:seed` – Run seeders
* `php artisan horizon` – Monitor queues

**Composer**

* `composer update` – Update PHP dependencies

**NPM**

* `npm run dev` – Development build
* `npm run prod` – Production build
* `npm run watch` – Watch file changes
* `npm run hot` – Hot reload

---

## Main Packages Used

* **Backend**

  * `laravel/framework`
  * `laravel/horizon`
  * `laravel/passport`
  * `laravel/sanctum`
  * `darkaonline/l5-swagger`
  * `fruitcake/laravel-cors`
  * `guzzlehttp/guzzle`
  * `predis/predis`
* **Frontend**

  * `laravel-mix`
  * `axios`
  * `lodash`
  * `postcss`
  * `laravel-echo-server`

---

## License

This project is licensed under the MIT License.

---

## Contribution & Support

Feel free to [open an issue](https://github.com//oomeryuce/chat-app-api) or submit a pull request.

For questions, reach out at: oomeryuce@gmail.com
