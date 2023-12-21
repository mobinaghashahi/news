<?php
require 'vendor/autoload.php';
require 'src/chat.php';
use Ratchet\Server\IoServer;
use ChatApp\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    1020
);
$server->run();
