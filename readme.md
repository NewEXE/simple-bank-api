# Simple Bank Api

Test task.

## Installation

Tested on Vagrant 2.0.2, Homestead 5.2.0, Ubuntu 16.04.

1. `git clone https://github.com/NewEXE/simple-bank-api.git`
2. `composer update --lock`
3. `cp .env.example .env`
4. `php artisan key:generate`
3. set up .env file
4. `php artisan migrate`
5. `php artisan db:seed`

### Cron command

`47 23 */2 * * php /var/www/artisan store:sum`

## Used libs
ixudra cURL library: https://github.com/ixudra/curl

## Unrealized features (for now)
1. ~~Unit-tests~~ (completed);
2. ~~All cUrl methods in Services/InternalApi~~ (completed);
3. ~~views code cleanup~~ (completed);
4. PHP documentation for API actions (@api);
5. Add repository for transactions.

## Proposed improvements for source task
1. Standardize API endpoints (make method, URI, action and route name such as Laravel resources - https://laravel.com/docs/5.6/controllers#resource-controllers);
