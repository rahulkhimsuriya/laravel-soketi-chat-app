# Laravel Soketi Chat App

A demo application to learn soketi with laravel broadcast.

## Installation

```sh
git clone https://github.com/rahulkhimsuriya/laravel-soketi-chat-app.git

cd laravel-soketi-chat-app
```

Install PHP dependencies:

```sh
composer install
```

Install node dependencies and build assets:

```sh
npm install && npm run build
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Change [broadcast driver](https://laravel.com/docs/9.x/broadcasting#pusher-channels) in you `.env` file :

```dotenv
BROADCAST_DRIVER=pusher
```

Setup [soketi](https://docs.soketi.app/getting-started/installation/cli-installation#installing-with-npm) configuration in you `.env` file:

> Note: if you're using pusher insted of soketi please change credentials accordingly.

```dotenv
PUSHER_APP_ID=app-id
PUSHER_APP_KEY=app-key
PUSHER_APP_SECRET=app-secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly. [Read more](https://laravel.com/docs/8.x/database)

```sh
touch database/database.sqlite
```

Run database migrations and seed database:

```sh
php artisan migrate --seed
```

Login credentials:

```
Email: john@example.com
Password: password
```

Run the dev server ([click me](http://127.0.0.1:8000)):

```sh
php artisan serve
```

## Thank you.
