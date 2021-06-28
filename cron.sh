#!/bin/bash
cd /public_html/circle-backend-php
git checkout -- .
git pull
cd /public_html/circle-backend-php/application
composer update --no-interaction --ansi
cd /public_html/circle-api-django
git checkout -- .
git pull
sudo rm -rf follower/__pycache__/ && sudo rm -rf like/__pycache__/ && sudo rm -rf photo/__pycache__/ && sudo rm -rf setup/__pycache__/ && sudo rm -rf geolocation/__pycache__/ && sudo rm -rf photo_statistic/__pycache__/ && sudo rm -rf log/__pycache__/ && sudo rm -rf log/migrations/__pycache__/ && sudo rm -rf mail/__pycache__/ && sudo rm -rf mail/migrations/__pycache__/ && sudo rm -rf log/migrations/__pycache__/ && sudo rm -rf system_data_information/__pycache__/ && sudo rm -rf system_data_information/migrations/__pycache__/ && sudo rm -rf user/__pycache__/  && sudo rm -rf user/migrations/__pycache__/ && sudo rm -rf follower/migrations/__pycache__/ && sudo rm -rf like/migrations/__pycache__/ && sudo rm -rf photo/migrations/__pycache__/ && sudo rm -rf setup/migrations/__pycache__/ && sudo rm -rf geolocation/migrations/__pycache__/ && sudo rm -rf photo_statistic/migrations/__pycache__/ && sudo rm -rf comment/migrations/__pycache__/