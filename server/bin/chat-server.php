<?php
use Ratchet\Server\IoServer;
use Ratchet\Server\EchoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
 
require dirname(__DIR__) . '/vendor/autoload.php';
 
$ws = new WsServer(new Chat);
 
$server = IoServer::factory(
    new HttpServer($ws),
    // 8080
    8081
);
 
$server->run();