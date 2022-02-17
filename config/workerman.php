<?php
/**
 * workerman 配置文件
 */

return [
    'gateway' => [
        'socket_name' => 'tcp://0.0.0.0:8282',
        // gateway 进程的名称
        'name' => 'Gateway',
        // gateway 进程数
        'count' => 4,
        // 本机ip，分布式部署时使用内网ip
        'lanIp' => '127.0.0.1',
        // 内部通讯起始端口，假如$gateway->count=4，
        // 起始端口为4000 则一般会使用4000 4001 4002 4003 4个端口作为内部通讯端口
        'startPort' => 2000,
        // 服务注册地址
        'registerAddress' => '127.0.0.1:1238',
        // 心跳间隔 /s
        'pingInterval' => 10,
        // 心跳数据
        'pingData' => '{"type":"ping"}',
        // 客户端不回应心跳时，1：关闭连接
        'pingNotResponseLimit' => 1,
    ],

    'business_worker' => [
        // worker 名称
        'name' => 'BusinessWorker',
        // bussinessWorker 进程数量
        'count' => 4,
        // 服务注册地址
        'registerAddress' => '127.0.0.1:1238',
        // 事件处理类，默认是 Event 类
        'eventHandler' => \Suzhif\LaravelWorkerman\Event\Event::class,
    ]
];