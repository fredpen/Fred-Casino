# Fred-Casino

A demo application to illustrate Fred-Casino.

## Installation
 
Clone the repo locally:
Open a terminal or a git client and clone the project using the code below

```sh
git clone https://github.com/fredpen/Fred-Casino.git Fred-Casino
cd Fred-Casino
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

Generate application key:

```sh
php artisan key:generate
```

Run database migrations and seeder:

```sh
php artisan migrate --seed
```


Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit http://127.0.0.1:8000 or the url generated from above in your browser

Register a user
login
