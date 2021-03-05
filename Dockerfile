FROM php:7.3
RUN mkdir /code
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
