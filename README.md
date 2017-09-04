# ZendFramework Application

# Introduction

Small online shop repository with no mobile version.

The repository is developed on ZF3 PHP7.0, uses DoctrineORM to work with DB.

All imgs are cropped and resized, minized to (270px x 270px) to make easy load for the user brawser while adding products.

Repository uses jQuery AJAX requests to delete, edit, add products,cats.

Repository was developed for demonstrating skills and can be much more improved if employer would like to see.
By September 5, mobile version will be added. 

# Requirements

PHP7.0 || >

## Installation

Just copy the repository and install by composer by 

```bash
composer install
composer update
```

command.


# 	DB
File shop.sql contains db structure for the repository.

   1. Create a db named "shop"
      if you use phpmyadmin, open db "shop", SQL command
   2. In field SQL command copy and paste the content of shop.sql
   3. Set username and password for the doctrine to work with db in config/autoload/doctrine.global.php
   4. That's it

# 	Other resources used in repository

Materializecss (materializecss.com)
Google icons  (material.io/icons)


# Author

If you have any questions or would like to talk to me you can contact me by beks.sch@gmail.com