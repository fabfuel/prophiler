FROM fabfuel/phalcon
COPY . /var/www/html
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install -o
