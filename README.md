# Life (Conway's Game of Life)

## Requirements
* Docker

## Installation
TL;DR: run `./deploy/up.sh`.

This application is dockerized, which means that everything happens inside a Docker container. The Nginx server is running inside the container (as the default entrypoint), the dependencies (Composer and NPM) are installed inside the container and PHP is executed inside the container.
To spin up the Docker container (build the image and run the container), just run `./deploy/up.sh`.

## Development
TL;DR: run `./deploy/local.up.sh` once and start coding.

When developing in a local environment, just run `./deploy/local.up.sh`.
This will build the image and run the container normally, but mounting volumes for the source and vendor folders.

By mounting volumes on those folders, it makes the dependencies (installed only inside the container) available outside the container (so available to your IDE).
Also it makes all changes on those folders reflect instantly inside the container, so there is no need to re-deploy.

Running `./deploy/local.up.sh` will also automatically tail the output of the container.

## Start-up scripts provided
* `up.sh`: (supposed to run on the host, located in `deploy/`) to deploy the application with configuration values optimized for production using environment variables
* `local.up.sh`: (supposed to run on the host, located in `deploy/`) to deploy the application in your development environment, tailing logs and mounting volumes for your source code, to work comfortably
* `configure.sh`: (supposed to run inside the Docker container, located in `/var/www`) it configures the run-time environment according to the `OPTIMIZE_`, `XDEBUG_` and `BASIC_AUTH_` environment variables
* `entrypoint.sh`: (supposed to run inside the Docker container, located in `/var/www`) executes `configure.sh` and starts the service (nginx and php-fpm) (this is the default entry point of the Docker container)

## Environment variables available
These environment variables are given a default value in the `up.sh` and `local.up.sh` (host) scripts, and also in the `configure.sh` and `entrypoint.sh` (container) scripts. The default value in any of the host scripts will override the default value in the container scripts.

|       ENV VAR        |                 Default value                 |           Description          |
| -------------------- | --------------------------------------------- | ------------------------------ |
| PROJECT_NAME         | Name of the project's root folder (`localhost` in the host container scripts)  | Used to name the docker image and docker container from the `up.sh` files, and as the name server in nginx. |
| HOST_PORT            | 80                                                                             | The port Docker will use as the host port in the network bridge. This is the external port, the one your app will be called through. |
| OPTIMIZE_PHP         | `true` (`false` in `local.up.sh`)                                              | Sets PHP's configuration values about error reporting and display [the right way](https://www.phptherightway.com/#error_reporting) and enables [OPCache](https://secure.php.net/book.opcache). |
| OPTIMIZE_COMPOSER    | `true` (`false` in `local.up.sh`)                                              | Optimizes Composer's autoload with [Optimization Level 2/A](https://getcomposer.org/doc/articles/autoloader-optimization.md#optimization-level-2-a-authoritative-class-maps). |
| BASIC_AUTH_ENABLED   | `true` (`false` in `local.up.sh`)                                              | Enables Basic Authentication with Nginx. |
| BASIC_AUTH_USERNAME  | admin                                                                          | If `BASIC_AUTH_ENABLED` is `true`, it will be used to run `htpasswd` together with `BASIC_AUTH_PASSWORD` to encrypt with bcrypt (cost 10). |
| BASIC_AUTH_PASSWORD  | `PROJECT_NAME`_password                                                        | If `BASIC_AUTH_ENABLED` is `true`, it will be used to run `htpasswd` together with `BASIC_AUTH_USERNAME` to encrypt with bcrypt (cost 10). |
| XDEBUG_ENABLED       | `false` (`true` in `local.up.sh`)                                              | Enables Xdebug inside the container. |
| XDEBUG_REMOTE_HOST   | 10.254.254.254                                                                 | Used as the `xdebug.remote_host` PHP ini configuration value. |
| XDEBUG_REMOTE_PORT   | 9000                                                                           | Used as the `xdebug.remote_port` PHP ini configuration value. |
| XDEBUG_IDE_KEY       | `PROJECT_NAME`_PHPSTORM                                                        | Used as the `xdebug.idekey` PHP ini configuration value. |

Example:
```bash
HOST_PORT=8000 BASIC_AUTH_ENABLED=true BASIC_AUTH_USERNAME=user BASIC_AUTH_PASSWORD=secure_password XDEBUG_ENABLED=true ./deploy/local.up.sh
```
You can also run the container yourself and override the container's command to run a different process instead of the normal application and web server:
```bash
docker run --name background-process --rm -v $PWD/src:/var/www/src --rm -e XDEBUG_ENABLED=true -e PROJECT_NAME=life life:latest /bin/sh -c "/var/www/configure.sh && php -i"
```

## Running commands
Since the application runs inside the container, all commands that affect the application have to be executed there. To do so, run `docker exec -it life /bin/sh -c "{command}"`.
For example, to run an Artisan command, run `docker exec -it life /bin/sh -c "src/artisan {command}"`

## Update dependencies
Whenever you want to update the dependencies, delete the lock files (`composer.lock` and `package-lock.json`), run the project again (with `up.sh` or `local.up.sh`)(this will update the dependencies and write the lock file inside the container) and extract the lock files from inside the container with:
```bash
docker cp life:/var/www/composer.lock .
```

## Xdebug support
Even though the project runs inside a Docker container, it still provides support for debugging with Xdebug. By telling Xdebug the remote location of your IDE and configuring this one to listen to certain port, they can communicate with one another.

Use the `XDEBUG_` environment variables to configure your project's debugging.

### Xdebug for PhpStorm on Mac
Check [this documentation](https://gist.github.com/gbmcarlos/77614789be8a6ecc1dc3aec4b49c07bc), sections "Configuring PhpStorm" and "Configuring MacOS". to configure your IDE and system.
Use the `XDEBUG_` environment variables and the path mappings:
* "src" -> `/var/www/src`
* "vendor" -> `/var/www/vendor`

## Built-in Stack
* [Alpine Linux 3.8 (:stretch slim)](https://hub.docker.com/_/alpine/)
* [Nginx 1.14.1](http://nginx.org/)
* [PHP 7.2.8 (:7.2-fpm-alpine)](https://hub.docker.com/_/php/)
* [Xdebug 2.6.1](https://xdebug.org/)
* [Laravel 5.7](https://laravel.com/docs/5.7/)
* [Node.js 8.11.4](https://nodejs.org/en/docs/)