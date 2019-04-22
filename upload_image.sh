#!/bin/bash

# Stop execution if a step fails
set -e

DOCKER_USERNAME=lbaw1863
IMAGE_NAME=lbaw1863
# Ensure that dependencies are available
composer install

# prepare deploy
php artisan cache:clear
php artisan clear-compiled
php artisan optimize

docker build -t $DOCKER_USERNAME/$IMAGE_NAME .
docker push $DOCKER_USERNAME/$IMAGE_NAME
