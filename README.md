## About the project

This is a miniature blogging platform, that allow users register and create their own blog posts, while also fetching admin blog posts from an external API.
The homepage shows all the created blogs while each users' dashboard also show the posts they have created.

## Project Environment

This was created with the Laravel framework version 8. And PHP version 8.0.
Other supporting libraries includes: Bootstrap CSS, Laravel Breeze and Font Awesome.

## Setup instructions

- Clone the project locally using the command `git clone git@github.com:IDTitanium/blog-square`

- Open the project folder on your terminal. `cd blog-square`

- Run the following commands,
    - `composer install` to install the project dependencies
    - `cp .env.example .env` to create an env file to store environment variables
    - `php artisan key:generate` to generate application key
    - `php artisan breeze:install` to install the Laravel breeze library
    - `npm install` to install Javascript dependencies
    - `npm run dev` to run/build the Javascript dependencies

## Database Setup
- Setup database credentials in the environment variable.
    - After setting up the credentials you can run the follow commands,
    - `php artisan migrate` to run all migrations and create the required database tables.
    - `php artisan db:seed` this will only seed the Admin user in your database.

## Scheduler Setup
- The project contains a scheduled job (cron) that runs every fifteen minutes for polling blog post from external API.
    - Run the command `php artisan schedule:work` to run the cron continously.
    - To instantly run the cron command once, you can run the command `php artisan poll:blogpost`.

## Testing
To run the tests, you can run `php artisan test` this will run all the available test on the project.

The `PostTest` and `DashboardTest` contain most of the feature tests for this  project, the others are authentication tests.


## Issues Reporting
If you find any issue with this project, kindly send an email to `idriseun222@gmail.com`
