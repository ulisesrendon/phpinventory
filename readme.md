# PHPInventory - Product stock management

![Made With](https://img.shields.io/badge/made_with-php-blue.svg)

### System requirements:
- PHP >= 8.2
- MariaDB or MySQL

## Installation

### 1 - Clone project with git
### 2 - Create and configure .env file with database and system variables
```
APP_DEBUG = 1

DB_DRIVE = 'mysql'
DB_HOST = 'localhost'
DB_PORT = 3306
DB_NAME = 'databasename'
DB_USER = 'databaseuser'
DB_PASSWORD = 'databasepassword'
```
### 3 - Install dependencies
```
composer update
```
### 4 - Create database structures
```
composer stradow-migrate
```