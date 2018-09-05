# Game Of Life Coding Test (PHP version)
## Assignment
This test is designed to assess a candidate's general level of PHP/JS coding ability without reference to any particular framework. It is intended to be a test of style as well as ability. You will implement a cellular automaton as per the rules of Conway's Game of Life, that can be found at http://en.wikipedia.org/wiki/Conway%27s_Game_of_Life.
 
The program will be able to be deployed onto a web server as a set of PHP/JS scripts that will output animated preview to the calling browser. The program will be delivered as a .tar.gz archive. You may include a 3rd party framework if you wish (this might help with providing unit tests)
 
A user will visit an index.php that will give them the choice of having either a random initial condition of the game grid, or a Gosper Glider Gun (info on this can be found at the above URL).  The user will be delivered a web page that includes an animated grid preview that shows at least the first 100 iterations of life based on a 38 x 38 starting grid. If you want you might extend functionalities further in example adding ability to save in database or local storage information about designed pattern/grid etc.
 
You will use Object-Oriented programming style. Try not to implement procedural code dressed up as objects (although given the nature of this task there will be limits)
 
Provide unit tests for extra marks. 
 
You will be judged on your coding style, on the efficiency of your implementation and whether you provide unit tests.

## Business Requirements
* The game of life functionality will be implemented purely in PHP
* The application will be implemented using Silex as a PHP framework and Docker.

### User journey

#### Front page
* In the front page the user will see two buttons, "Random pattern", and "Gosper Glider Gun". 
* Each of the button will redirect the user to a different page. 

#### Random pattern page
* This page will show a functional grid of 38x38 started with a random pattern.
* The grid will show the 100 first iterations of the game

#### Gosper Glider Gun page
* This page will show a functional grid of 38x38 started with a Gosper Glider Gun.
* The grid will show the 100 first iterations of the game

### Tests
Tests are implemented with PHPUnit and can be run by executing `./deploy/tests.sh`.

## Requirements
- Docker
- MySQL server (>=5.6) with a database named "ecp"

## Installation
TL;DR: run `./deploy/up.sh`.

This application is dockerized, which means that everything happens inside a Docker container. The Apache server is running inside the container (as the default entrypoint), the dependencies (Composer and NPM) are installed inside the container and PHP is executed inside the container.
To spin up the Docker container (build the image and run the container), just run `./deploy/up.sh`.

## Development
TL;DR: run `./deploy/local.up.sh` once and start coding.

When developing in a local environment, just run `./deploy/local.up.sh`.
This will build the image and run the container normally, but mounting volumes for the source and vendors folders.

By mounting volumes on those folders, it makes the dependencies (installed only inside the container) available outside the container (so available to your IDE).
Also it makes all changes on those folders reflect instantly inside the container, so there is no need to re-deploy.

Running `./deploy/local.up.sh` will also automatically tail the output of the container.

## Environment variables available
These environment variables are used and given a default value only in the `up.sh` and `local.up.sh` scripts as part of the docker `build` and `run` commands. If you build the docker image and run the docker container on your own, make sure to pass the values to those commands accordingly.

|       ENV VAR        |                 Default value                 | Description |
| -------------------- | --------------------------------------------- | ----------- |
| PROJECT_NAME         | Name of the project's root folder             | Used to name the docker image and docker container from the `up.sh` files |
| HOST_PORT            | 80                                            | The port Docker will use as the host port in the network bridge. This is the external port, the one your app will be called through |
| OPTIMIZE_PHP         | `true` for `up.sh`, `false` for `local.up.sh` | Set PHP's configuration values about error reporting and display [the right way](https://www.phptherightway.com/#error_reporting) and enables [OPCache](https://secure.php.net/book.opcache) (build argument only) |
| OPTIMIZE_COMPOSER    | `true` for `up.sh`, `false` for `local.up.sh` | Optimize Composer's autoload with [Optimization Level 2/A](https://getcomposer.org/doc/articles/autoloader-optimization.md#optimization-level-2-a-authoritative-class-maps) (build argument only) |
| OPTIMIZE_ASSETS      | `true` for `up.sh`, `false` for `local.up.sh` | Optimize assets compilation (build argument only) |
| BASIC_AUTH_ENABLED   | `true` for `up.sh`, `false` for `local.up.sh` | Enable Basic Authentication with Apache (Persisted environment variable) |
| BASIC_AUTH_USER      | admin                                         | If `BASIC_AUTH_ENABLED` is `true`, this will be used to run `htpasswd` together with `BASIC_AUTH_PASSWORD` to encrypt with bcrypt (cost 10) (build argument only) |
| BASIC_AUTH_PASSWORD  | `PROJECT_NAME`_password                       | If `BASIC_AUTH_ENABLED` is `true`, this will be used to run `htpasswd` together with `BASIC_AUTH_USER` to encrypt with bcrypt (cost 10) (build argument only) |
| XDEBUG_ENABLED       | `false` for `up.sh`, `true` for `local.up.sh` | Enables Xdebug inside the container. More information on how to configure your system below. (build argument only) |
| XDEBUG_REMOTE_HOST   | 10.254.254.254                                | Used as the `xdebug.remote_host` PHP ini configuration value (build argument only) |
| XDEBUG_REMOTE_PORT   | 9000                                          | Used as the `xdebug.remote_port` PHP ini configuration value (build argument only) |
| XDEBUG_IDE_KEY       | `PROJECT_NAME`_PHPSTORM                       | Used as the `xdebug.idekey` PHP ini configuration value (build argument only) |

## Running commands
Since the application runs inside the container, all commands have to be executed there. To do so, run `docker exec -it game-of-life-php /bin/sh -c "{command}"`.
For example, to run a Artisan command, run `docker exec -it game-of-life-php /bin/sh -c "php artisan"`

## Admin user
The first time you will need to create and admin user. Run the `createAdminUser` artisan-enabled command (i.e.: `docker exec -it game-of-life-php /bin/sh -c "php artisan createAdminUser"`.
It will ask for name, email and password and then it will create the admin user in the database. 
After logging in as the admin user you can then go to the users management section and create other users.

## Watch assets
To watch the assets (see the compiled changes instantly reflect after every change) run `docker exec -it -w /var/www game-of-life-php /bin/sh -c "node_modules/webpack/bin/webpack.js --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js --watch"`

## Update dependencies (extract lock files)
Composer lock: `docker cp {{projectName}}:/var/www/composer.lock $PWD/composer.lock`

## Xdebug support
Even though the project runs inside a Docker container, it still provides support for debugging with Xdebug. By telling Xdebug the remote location of your IDE and configuring this one to listen to certain port, they can communicate with one another.

Use the `XDEBUG_` environment variables to configure your project's debugging.

### Xdebug for PhpStorm on Mac
Check [this documentation](https://gist.github.com/gbmcarlos/f90bef184873c46c6186880b3d633ff6), sections "Configuring PhpStorm" and "Configuring MacOS". to configure your IDE and system.
Use the `XDEBUG_` environment variables and the path mappings:
* "src" -> `/var/www/src`
* "vendor" -> `/var/www/vendor`