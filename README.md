
## Readme file.
## About

<br>
<hr>

This is a sample code.

In order to start there is a docker-compose file with three main services. _Nginx_, _Php-fpm_, and _Mysql_.

The Mysql service comes with a root user and password and an init file where is 
instantiated the necessary databases: _the main one and a testing database_.

In order to start run `make` on the terminal or `docker-compose up -d`.

This will run all the necessary docker containers.

The application will be running in webserver IP address: `177.123.179.1`

<hr>

After that is important to _prepare/seed_ the database you can run

`mysql -u root -p -h 177.123.179.3 bitpanda_database < docker/mysql/database_dump.sql`

`mysql -u root -p -h 177.123.179.3 bitpanda_database < docker/mysql/transactions.sql`

Testing database

provide a .env.testing
with a testing database _only_ with the database schema

To run tests in php storm stop the containers `docker-compose stop` and then go to settings>test frameworks and set the CLI INTERPRETER to php-fpm service.

Then set the lifecycle to connect to existing container _(docker-compose exec)_

<hr>


Please don't forget to prepare the `.env` file and specially set the database connection.

<hr>
#### This is only for sample for more worked documentation OpenApi would be used.
<hr>

Endpoints:

<br>

[GET api/users/](http://177.123.179.1/api/users)

[PUT api/users/{userId}]()
    
    citizenship_country_id: required integer
    first_name: required string
    last_name: required string
    phone_number: required number

[DELETE api/users/{userId}]()

<hr> 

[GET api/transactions](http://177.123.179.1/api/transactions?source=csv)
    
    query_params: enum[db, csv]
