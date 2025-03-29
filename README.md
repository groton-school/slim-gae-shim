# groton-school/slim-gae-shim

[![Latest Version](https://img.shields.io/packagist/v/groton-school/slim-gae-shim.svg)](https://packagist.org/packages/groton-school/slim-gae-shim)

```sh
composer create-project slim/slim-skeleton [my-app-name]
cd [my-app-name]
composer require groton-school/slim-gae-shim
cp vendor/groton-school/slim-gae-shim/.gcloudignore .
cp vendor/groton-school/slim-gae-shim/app.yaml .
cp -R vendor/groton-school/slim-gae-shim/bin .
cp vendor/groton-school/slim-gae-shim/package.json .
cp vendor/groton-school/slim-gae-shim/php.ini .
npm install
```

Implement `GrotonSchool\Slim\GAE\SettingsInferface` and `DI\get()` the implementation. Also, inject the dependencies and routes from the shim:

`app/dependencies.php`
```php
$containerBuilder->addDefinitions([
    GrotonSchool\Slim\GAE\SettingsInterface::class => DI\get(App\Application\Settings::class)
]);
GrotonSChool\Slim\GAE\Dependencies::addDefinitions($containerBuilder);
```

`app/routes.php`
```php
GrotonSchool\Slim\GAE\Routes::register($app);
```