# What's this?
This skeleton allows to have a working Silex application running inside a docker container completely out of the box.
The application is ready to be run locally by executing the `config/up.sh` script.
# Features
* Run as a Docker container: 
* Run as a Docker container: only one dependency, Docker. It can be deployed in any decent modern server. It can be deployed in a matter of 2-4 minutes
* Apache with configurable ports: Both the external and the internal ports are configurable as environment variables. This allows to run the container as a non-root user (as some third-party Docker build services do), so Apache can bind ports other than 80 and 443
* Silex application: backed and endorsed by Symfony and its components, nothing else to say.
* Service and routing registrars: register services (and controllers) and routes easily
* Packed with Bootstrap and jQuery: included from CDNs in the Twig layout
* `up.sh` included: get the application running in your local with the command `./deploy/up.sh 80 8000`
# How to use it
* Clone this repository with `git clone`. You can clone into a a directory with a different name by running `git clone https://github.com/gbmcarlos/docker-silex-skeleton.git {project-name}`
* Remove the old remote and add the new one by running `git remote rm origin && git remote add origin https://github.com/{you}/{project-name}.git`
* Start working