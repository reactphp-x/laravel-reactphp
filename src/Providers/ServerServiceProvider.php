<?php
namespace ReactphpX\LaravelReactphp\Providers;

use Illuminate\Support\ServiceProvider;
use ReactphpX\LaravelReactphp\Commands\HttpServerCommand;
use ReactphpX\LaravelReactphp\Http\ServerManager;
use FrameworkX\App;

class ServerServiceProvider extends ServiceProvider
{
    protected $defer = false;
    /**
     * @var \React\Http\Server | \React\Socket\Server
     */
    protected static $server;

    public function register()
    {
        $this->mergeConfigs();
        $this->registerLoop();
        $this->registerServer();
        $this->registerManager();
        $this->registerCommands();
    }

    public function boot()
    {
       $this->requireRoute();
    }

    protected function requireRoute()
    {
        $routeFile = $this->app['config']->get('reactphp.server.route_file');
        if (file_exists($routeFile)) {
            require $routeFile;
        }
    }

    protected function mergeConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/reactphp_server.php', 'reactphp');
    }

    protected function registerLoop()
    {
        $this->app->singleton('React\EventLoop\LoopInterface', function ($app) {
            return \React\EventLoop\Loop::get();
        });

        $this->app->alias('React\EventLoop\LoopInterface', 'reactphp.loop');
    }

    protected function registerServer()
    {
        $this->app->singleton('reactphp.server', function ($app) {
            return new App(new \FrameworkX\Container($app), ...$app['config']->get('reactphp.middlewares', []));
        });
    }

    protected function registerCommands()
    {
        $this->commands([
            HttpServerCommand::class
        ]);
    }

    /**
     * Register server manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('reactphp.manager', function ($app) {
            return new ServerManager($app);
        });
    }
}