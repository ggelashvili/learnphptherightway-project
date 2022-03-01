FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY crontab /etc/crontabs/root
RUN mkdir /var/log/cron

CMD ["crond", "-f"]

