<?php
/**
 * Created by PhpStorm.
 * Author: suzhiF 2022/2/15
 */

namespace Suzhif\LaravelWorkerman\Event;

use GatewayWorker\BusinessWorker;

interface BaseEvent
{
    /**
     * 当 businessWorker 进程启动时触发
     * 每个进程生命周期内都只会触发一次
     * 可以在这里为每一个 businessWorker 进程做一些全局初始化工作，例如设置定时器，初始化 redis 等连接等
     *
     * @param BusinessWorker $businessWorker   businessWorker进程实例
     */
    public static function onWorkerStart($businessWorker);

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id);

    /**
     * 当客户端连接上 gateway 完成 websocket 握手时触发的回调函数
     * 此回调只有 gateway 为 websocket 协议并且 gateway 没有设置 onWebSocketConnect 时才有效
     *
     * @param string $client_id
     * @param array $data
     */
    public static function onWebSocketConnect($client_id, $data);

    /**
     * 当客户端发来消息时触发
     *
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message);

    /**
     * 当用户断开连接时触发
     * 不管是客户端主动断开还是服务端主动断开，都会触发这个回调
     *
     * @param int $client_id 连接id
     */
    public static function onClose($client_id);

}