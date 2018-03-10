# Laravel RSS feed aggregator
Laravel RSS feed aggregator is an example project written on Laravel 5.6 to show you how to use Laravel framework's structure and features to build simple web application.
### Tech

* Laravel 5.6
* Twitter Bootstrap 4
* ES6

### Reqruirements

* PHP >= 7.1.3


### Installation

```sh
composer install
```
Rename ```.env.example``` to ```.env``` and fill your configuration settings.

#### Installing database:
```sh
php artisan migrate
```

#### Re-building CSS/JS assets:
```sh
npm install
npm run prod
```

### Testing project:

```sh
vendor/bin/phpunit
```

Default testing configuration is set to sqlite memory. Configuration can be found: ```phpunit.xml```

### Running project:

#### Creating admin user:

```sh
php artisan user:create
```
#### Serve the application on the PHP development server:

```sh
php artisan serve
```

#### Updating Feeds:
```sh
php artisan feed:update
```




License
----

MIT

**Free Software**
