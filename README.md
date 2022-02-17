<h1 align="center"> laravel-workerman </h1>

<p align="center"> WorkerMan and Laravel integration SDK.</p>


## 安装

```shell
$ composer require suzhif/laravel-workerman
```

## 配置

~~~
php artisan vendor:publish --provider="Suzhif\LaravelWorkerman\WorkermanServiceProvider"
~~~

`config/workerman.php`

~~~php
<?php

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
~~~

## 启动

#### windows 系统下

项目根目录下新建文件 `start_for_win.bat` :
~~~
start /b php artisan workerman start --name=register
start /b php artisan workerman start --name=gateway
start /b php artisan workerman start --name=worker
pause
~~~

双击启动
~~~
>start /b php artisan workerman start --name=register

>start /b php artisan workerman start --name=gateway

>start /b php artisan workerman start --name=worker

>pause
请按任意键继续. . . ----------------------- WORKERMAN -----------------------------
Workerman version:4.0.27          PHP version:7.3.4
------------------------ WORKERS -------------------------------
worker                        listen                              processes status
Register                      text://0.0.0.0:1238                 1         [ok]
----------------------- WORKERMAN -----------------------------
Workerman version:4.0.27          PHP version:7.3.4
------------------------ WORKERS -------------------------------
worker                        listen                              processes status
Gateway                       tcp://0.0.0.0:8282                  4         [ok]
----------------------- WORKERMAN -----------------------------
Workerman version:4.0.27          PHP version:7.3.4
------------------------ WORKERS -------------------------------
worker                        listen                              processes status
BusinessWorker                none                                4         [ok]

~~~

> WorkerMan 官网：[windows操作系统下如何初始化多个Worker](https://www.workerman.net/doc/workerman/faq/multi-woker-for-windows.html)


#### Linux 系统下

以debug（调试）方式启动  (start|stop|restart|reload|status)
~~~
php artisan workerman start
~~~
以daemon（守护进程）方式启动
~~~
php artisan workerman start --d
~~~

~~~
$ php artisan workerman start --d
Workerman[workerman] start in DAEMON mode
------------------------------------------ WORKERMAN ------------------------------------------
Workerman version:4.0.27          PHP version:8.0.14
------------------------------------------- WORKERS -------------------------------------------
proto   user            worker            listen                 processes    status
tcp     admin_s         Register          text://0.0.0.0:1238    1             [OK]
tcp     admin_s         Gateway           tcp://0.0.0.0:8282     4             [OK]
tcp     admin_s         BusinessWorker    none                   4             [OK]
-----------------------------------------------------------------------------------------------
Input "php workerman stop --d" to stop. Start success.
~~~


## License

MIT