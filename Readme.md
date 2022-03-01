This project provides a CRUD operation on ticket entity

You must build the dockerfile image using the following command line

`./bin/docker_build.sh
`

You can now run docker-compose

`docker-compose up -d
`

Install the project via:

`composer install
`

Create a copy of `app/settings.php.dist` to `app/settings.php`

Initialize your database parameters.

Import the `importSql.sql` in your database

Ypu have to be ine the project root directory and run the following command line (Make sure of the directory right):

`php -S 0.0.0.0:8080 -t public`

Api endpoints:
* Ticket list          GET     /tickets         you can filter by name like ?filter={"totalCall":"boolean"}, ?filter={"topTen":"boolean"}, ?filter={"totalSMS":"boolean"}
* Single ticket        GET     /tickets/{id}
* Delete one ticket    DELETE  /tickets/{id}
* Create one ticket    POST    /tickets         the request shall be formatted like {"name":"<Non>","description":"<description>"}
* Update one ticket    PUT     /tickets/{id}    the request shall be formatted like {"name":"<Non>","description":"<description>"}
