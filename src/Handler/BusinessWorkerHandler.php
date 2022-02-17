<?php
/**
 * Created by PhpStorm.
 * Author: suzhiF 2022/2/16
 */

namespace Suzhif\LaravelWorkerman\Handler;


use GatewayWorker\BusinessWorker;

class BusinessWorkerHandler extends BusinessWorker
{
    public function __construct($socket_name = '', $context_option = array())
    {
        $config = config('workerman.business_worker');
        $this->name = $config['name'];
        $this->count = $config['count'];
        $this->registerAddress = $config['registerAddress'];
        $this->eventHandler = $config['eventHandler'];

        parent::__construct($socket_name, $context_option);
    }

}