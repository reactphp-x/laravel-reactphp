<?php

namespace ReactphpX\LaravelReactphp\Http;


use Psr\Http\Message\ServerRequestInterface;
use React\Stream\WritableResourceStream;
use ReactphpX\LaravelReactphp\Utils\IllumitateRequestBuilder;
use ReactphpX\LaravelReactphp\Utils\ReactPHPResponseBuilder;
use Symfony\Component\Process\Process;

class ServerManager
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
        $this->initialize();
    }

    protected function initialize()
    {
        $this->bindListeners();
    }

    protected function bindListeners()
    {
//         $this->app['reactphp.server']->on('error', function (\Throwable $e) {
//             echo  'Error: ' . $e->getMessage() . PHP_EOL;
//             echo  'File: ' . $e->getFile() . PHP_EOL;
//             echo  'Line: ' . $e->getLine() . PHP_EOL;
// //            echo  'Stacktrace: ' . $e->getTraceAsString() . PHP_EOL;
//         });
    }

    protected function getPidFile()
    {
        return $this->app['config']->get('reactphp.server.options.pid_file');
    }

    protected function createPidFile()
    {
        file_put_contents($this->getPidFile(), getmypid());
    }

    public function removePidFile()
    {
        $pidFile = $this->getPidFile();
        if (file_exists($pidFile)) {
            unlink($pidFile);
        }
    }

    public function getPid()
    {
        $pid = null;
        $pidPath = $this->getPidFile();
        if(file_exists($pidPath)) {
            $pid = (int) file_get_contents($pidPath);

            if(!$pid) {
                $this->removePidFile();
            }
        }

        return $pid;
    }

    public function stop()
    {
        $process = new Process(['kill', 15, $this->getPid()]);
        $process->run();

        return $process->isSuccessful();
    }

    protected function isRunning()
    {
        $pid = $this->getPid();
        if(!$pid) {
            return false;
        }

        return true;
    }

    public function run()
    {
        $this->createPidFile();
        $writable = new WritableResourceStream(STDOUT, $this->app['reactphp.loop']);
        $writable->write("\nListening on ".env('X_LISTEN')." \n");
        $this->app['reactphp.server']->run();
    }
}