#!/usr/bin/env bash
PORT_OUTSIDE=${1:-80}
PORT_INSIDE=${2:-8080}

echo ">>>> Moving to $(dirname "$0")"
cd "$(dirname "$0")"
echo ">>>> Building docker image"
docker build -t game_of_life:latest $PWD/..

echo ">>>> Removing old container"
docker rm -f game_of_life || true

echo ">>>> Running new container"
docker run --name game_of_life -e APP_ENV=local -e APP_DEBUG=TRUE -e PORT=$PORT_INSIDE -d -p $PORT_OUTSIDE:$PORT_INSIDE game_of_life:latest

echo ">>>> Tailing logs"
docker logs -f game_of_life