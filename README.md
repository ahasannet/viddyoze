# Symfony 4 Doctrine MySQL Cart

# Technical Requirements
- PHP 7.2.5 or higher
- Composer
- Symfony
- mysql 5.6 or higher

# Installation
- run `git clone https://github.com/ahasannet/viddyoze.git` command
- run `cd viddyoze` in command line
- run `composer install`
- modify `.env` from root directory for MYSQL connection
`DATABASE_URL=mysql://root:@127.0.0.1:3306/viddyoze?serverVersion=5.7`
- run `php bin/console doctrine:database:create` to create database
- run `php bin/console make:migration` for create migration review
- run `php bin/console doctrine:migrations:migrate` for create tables
- import `viddyoze.sql` into mysql database
- run `symfony server:start`
- visit `http://127.0.0.1:8000/` in browser
- use different browser for different session
