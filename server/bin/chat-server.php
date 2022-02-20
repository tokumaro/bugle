<?php
use Ratchet\Server\IoServer;
use Ratchet\Server\EchoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
 
require dirname(__DIR__) . '/vendor/autoload.php';
$chat = new Chat();
$ws = new WsServer($chat);
 
$server = IoServer::factory(
    new HttpServer($ws),
    // 8080
    8081
);
$server->loop->addPeriodicTimer(5,function () use ($chat){
    $chat->udpstatus_loop();
});
$server->run();