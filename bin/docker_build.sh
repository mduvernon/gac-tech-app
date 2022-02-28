#!/bin/bash
# @todo - create random passphrase: tr -dc 'A-Za-z0-9!#$%&*+-:;<=>?@^_~' </dev/urandom | head -c 50  ; echo

# @todo - run using sudo
# ./docker_build.sh
docker build --network host \
  -t gac_backend_img .
