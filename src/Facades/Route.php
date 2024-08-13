<?php

namespace ReactphpX\LaravelReactphp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method void static get(string $route, $handler, ...$handlers)
 * @method void static post(string $route, $handler, ...$handlers)
 * @method void static put(string $route, $handler, ...$handlers)
 * @method void static delete(string $route, $handler, ...$handlers)
 * @method void static patch(string $route, $handler, ...$handlers)
 * @method void static options(string $route, $handler, ...$handlers)
 * @method void static head(string $route, $handler, ...$handlers)
 * @method void static any(string $route, $handler, ...$handlers)
 * @method void static addGroup(string $prefix, array $handlers, callable $callback)
 * @method void static group(string | array | callable $prefix, ...$handlers)
 * @method void static middleware(...$middlewares)
 * @method void static map(array $methods, string $route, $handler, ...$handlers)
 */

class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'reactphp.server';
    }
}