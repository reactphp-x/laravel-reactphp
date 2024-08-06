# reactphp-framework/laravel-reactphp
A package to use Laravel with ReactPHP ref https://github.com/danielmadu/laravel-reactphp

# How to use

## Install


```shell
composer require reactphp-framework/laravel-reactphp -vvv
```


## Run

```shell
php artisan reactphp:http start
```

## config

.env

```
X_LISTEN=0.0.0.0:8080
```

config/reactphp.php

```php
[
    'server' => [
        'route_file' => '',
        'public_path' => base_path('public'),
        'options' => [
            'pid_file' => env('REACTPHP_PID_FILE', base_path('storage/logs/reactphp_server.pid')),
            'log_file' => env('REACTPHP_LOG_FILE', base_path('storage/logs/reactphp_server.log')),
            'daemonize' => env('REACTPHP_HTTP_DAEMONIZE', false),
        ],
    ],
    'middlewares' => [
        // Add your middleware here
    ],

]
```

route

```
'route_file' => base_path('routes/api.php'),
```
routes/api.php

```php
<?php

// see https://github.com/clue/framework-x/

$app = app('reactphp.server');

$app->get('/', function () {
    return \React\Http\Message\Response::plaintext(
        "Hello wörld!\n"
    );
});

$app->get('/users/{name}', function (\Psr\Http\Message\ServerRequestInterface $request) {
    return \React\Http\Message\Response::plaintext(
        "Hello " . $request->getAttribute('name') . "!\n"
    );
});

```

## License

The Laravel-ReactPHP package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
