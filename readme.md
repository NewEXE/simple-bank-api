# Simple Bank Api

Test task.

# Installation

Tested on Vagrant 2.0.2, Homestead 5.2.0, Ubuntu 16.04.

1. `git clone https://github.com/NewEXE/simple-bank-api.git`
2. `composer update --lock`
3. `cp .env.example .env`
4. `php artisan key:generate`
3. set up .env file
4. `php artisan migrate`
5. `php artisan db:seed`

# Used libs
ixudra cURL library: https://github.com/ixudra/curl