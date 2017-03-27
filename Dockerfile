# See https://github.com/docker-library/php/blob/4677ca134fe48d20c820a19becb99198824d78e3/7.0/fpm/Dockerfile
# buddhikajay/rich-file-manager

FROM php:7.0-fpm
MAINTAINER Buddhika Jayawardhana <buddhika.anushka@gmail.com>

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Asia/Colombo /etc/localtime
RUN "date"

COPY . /var/www/RichFilemanager
RUN chown -R www-data /var/www/RichFilemanager
WORKDIR /var/www/RichFilemanager
