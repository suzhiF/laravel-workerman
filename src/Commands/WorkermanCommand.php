<?php

namespace Suzhif\LaravelWorkerman\Commands;

use GatewayWorker\Register;
use Illuminate\Console\Command;
use Suzhif\LaravelWorkerman\Handler\BusinessWorkerHandler;
use Suzhif\LaravelWorkerman\Handler\GatewayHandler;
use Workerman\Worker;

class WorkermanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman {action} {--name= register、gateway、worker} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workerman 服务命令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $worker_name = $this->option('name');
        if (strpos(strtolower(PHP_OS), 'win') === 0) {
            $this->start_for_win($worker_name);
            return;
        }

        // 检查扩展
        if (!extension_loaded('pcntl')) {
            $this->error("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
            return;
        }
        if (!extension_loaded('posix')) {
            $this->error("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
            return;
        }

        global $argv;
        $action = $this->argument('action');

        $argv[0] = 'workerman';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';

        $this->start();
    }

    /**
     * Linux 下启动方式
     */
    private function start()
    {
        $this->startRegister();
        $this->startGateWay();
        $this->startBusinessWorker();

        Worker::runAll();
    }

    /**
     * windows 下启动方式
     * @param string $worker_name 服务名称 (register|gateway|worker)
     */
    private function start_for_win($worker_name)
    {
        if (empty($worker_name)) {
            $this->error('The "name" argument does not exist');
            return;
        }
        if ($worker_name == 'register') {
            $this->startRegister();
        }
        if ($worker_name == 'gateway') {
            $this->startGateWay();
        }
        if ($worker_name == 'worker') {
            $this->startBusinessWorker();
        }
        Worker::runAll();
    }

    private function startBusinessWorker()
    {
        new BusinessWorkerHandler();
    }

    private function startGateWay()
    {
        new GatewayHandler();
    }

    private function startRegister()
    {
        new Register('text://0.0.0.0:1238');
    }
}
