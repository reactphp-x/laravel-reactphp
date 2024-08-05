<?php
namespace ReactPHPLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use ReactPHPLaravel\Commands\HttpServerCommand;
use ReactPHPLaravel\Http\ServerManager;
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