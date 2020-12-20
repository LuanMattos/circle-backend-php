#!/bin/bash
cd /public_html/circle-backend-php
git checkout -- .
git pull
cd /public_html/circle-backend-php/application
composer update --no-interaction --ansi