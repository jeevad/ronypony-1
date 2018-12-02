## Ronypony ##

### Website [Ronypony](https://www.ronypony.com/)


### Prerequisites ###

    *  Webserver(apache) >= 2.4
    *  PHP >=7.1.3,
    *  Laravel = 5.7.*
    *  Mysql >= 8.0
    *  Composer >= 1.5.2
    *  Redis >= 3.0
    *  NodeJS >= 8.9.1
    *  NPM >= 5.5.1
    *  Yarn >= 1.3.2
    *  git >= 2.7.4

## PHP extensions ##

    *  ext-bcmath
    *  ext-zip

### Installation ###

* run `sudo a2enmod rewrite`
* run `sudo service apache2 restart`
* run `git clone https://github.com/samayamnag/ronypony.git <projectname>` to clone the repository
* run `cd <projectname>`
* run `sudo apt-get install php7.x-bcmath && apt-get install php7.x-zip`
* run `cp .env.example .env`
* run `chmod 400 .env && chown -R www-data:www-data .env` to secure from public access
* run `composer install --no-interaction --prefer-dist --optimize-autoloader`
* Create a database and configure database(MongoDB also) in *.env*
* `Give permissions to storage/logs and bootstrap/cache folders`
* run `php artisan key:generate`
* run `php artisan migrate`
* Create virtual host for the project something like http://web.ronypony.local/ (optional)

### JWT token ###
* run `php artisan jwt:secret` to generate secret key

### Database seeding ###
* run `php artisan db:seed`
