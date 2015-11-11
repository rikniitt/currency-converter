#!/usr/bin/env bash

## Vagrant provision script, which
#  is supposed to run as non-privileged
#  user. Script installs the project
#  and required dependencies.

# First, go to project dir
cd /vagrant/

# Install composer
curl -sS https://getcomposer.org/installer | php

# Install php dependencies
#php composer.phar installer

# Install nodejs dependencies
#npm install

# Build project
#php artisan curr:build
