
## About

Sample code.

In order to start there is a docker-compose file with three main services. _Nginx_, _Php-fpm_, and _Mysql_.

The Mysql service comes with a root user and password and an init file where is 
instantiated the necessary databases: _the main one and a testing database_.

In order to star run `make` on the terminal.

This will run the docker-compose, migrate, composer install.

After that is important to seed the database you can run

`mysql -u root -p -h 177.123.179.3 bitpanda_database < docker/mysql/database_dump.sql`

`mysql -u root -p -h 177.123.179.3 bitpanda_database < docker/mysql/transactions.sql`

Testing database

provide a .env.testing
with a testing database _only_ with the database schema


Please don't forget to prepare the `.env` file and specially set the database connection.

####I would use OpenApi.
Endpoints:

[GET api/users/]() 

[PUT api/users/{userId}]()
    
    citizenship_country_id: required integer
    first_name: required string
    last_name: required string
    phone_number: required number

[DELETE api/users/{userId}]()


[GET api/transactions]()
    
    query_params: enum[db, csv]
