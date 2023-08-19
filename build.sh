#!/bin/bash
docker-compose build
docker-compose run --rm app composer install

image_name=$(docker-compose config | grep image: | awk '{print $2}')
echo "Image name: $image_name"

image_version=$(docker image inspect "$image_name" --format '{{ index .RepoTags 0}}' | awk -F ":" '{print $2}')
echo "Image version: $image_version"
