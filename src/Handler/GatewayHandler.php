<?php
/**
 * Created by PhpStorm.
 * Author: suzhiF 2022/2/15
 */

namespace Suzhif\LaravelWorkerman\Handler;

use GatewayWorker\Gateway;

class GatewayHandler extends Gateway
{

    public function __construct($context_option = array())
    {
        $config = config('workerman.gateway');

        $this->name = $config['name'];
        $this->count = $config['count'];
        $this->lanIp = $config['lanIp'];
        $this->startPort = $config['startPort'];
        $this->pingInterval = $config['pingInterval'];
        $this->pingNotResponseLimit = $config['pingNotResponseLimit'];
        $this->pingData = $config['pingData'];
        $this->registerAddress = $config['registerAddress'];

        parent::__construct($config['socket_name'], $context_option);
    }
}