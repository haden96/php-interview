# PHP Recruitment test


## Task 1

Fork this git repository.

**_Make sure to commit Your work after every completed task._**

Do **NOT** make pull requests against this repository to submit Your solutions

Application uses:
* PHP ^7.1.3
* [composer](http://getcomposer.org)
* [laravel](https://laravel.com/docs/5.6/installation#server-requirements)
* MySql or PostgreSQL

Install and configure application by running following commands

```
composer install
mv .env.example .env
```
Enter your DB connection (use `DB_CONNECTION=pgsql` for PostgreSQL) in .env file and then:
```
php artisan migrate
php artisan db:seed
```

//You can run PHP build-in server by running following command
`php artisan serve`

//The web application is running at http://127.0.0.1:8000.

Now create `.gitignore` file appropriate for Your development environment.

## Task 2

Run `php artisan bookingApp:calculateDistanceToOffice`. You will see that it fails. Fix this.

> **Hint:** You may need to call `composer dump-autoload` after fix

## Task 3

Open `Proexe\BookingApp\Utilities\DistanceCalculator` and finish writing two functions. First one should calculate distance between two gps point in meters or kilometers.  
Second method should find closest office. Call `php artisan bookingApp:calculateDistanceToOffice` to check what type of data is provided for both functions.

> **Hint:** you can modify `App\Console\Commands\CalculateDistanceToOffice` to optimize your solution 

Anywhere inside DistanceCalculator class write out as comment proposed pure SQL (for Mysql or Postgres) solution for finding closest office.  

## Task 4

Look at `App\Console\Commands\CalculateResponseTime`. We provided variable containing bookings and related office. 
Calculate for each booking response time (difference between updated_at and created_at) ignoring periods when office was closed.
eg.: 

```` 
created_at = 2018-08-04 16:00:00 (Sat)
updated_at = 2018-08-06 9:30:00 (Mon)
Opening hours: 
Mon - Sat: 9:00 - 18:00
Sat: closed

Response time will be: 120 minutes on Sat + 30 min on Mon = 150 minutes
````

> **Hint:** You can use `$this->line()` to write each result to console.

> **Hint:** Call `php artisan bookingApp:CalculateResponseTime` to run command.

Your solution **has to** implement `Proexe\BookingApp\Offices\Interfaces\ResponseTimeCalculatorInterface`  

Office hours are stored in `booking['office']['office_hours']` array starting with **Sunday on index 0**.

You can use any library you want to manipulate dates. 

## Task 5

Create unit test for Taks 4 covering edge cases. Test in Laravel are located in /tests/Unit where we prepared `BookingResponseTimeTest`

> **Hint:** Laravel is configured with phpunit. If you don't have your own installation you may use `vendor/bin/phpunit`. 
If that fails for any reason don't waste your time trying to fix this. We will look only at your test coverage.  

