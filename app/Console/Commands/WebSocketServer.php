<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\WebSocketServer as WebSocketHandler;

class WebSocketServer extends Command
{
    protected $signature = 'websocket:start';
    protected $description = 'Iniciar el servidor WebSocket';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketHandler()
                )
            ),
            3001
        );

        echo "Servidor WebSocket escuchando en ws://localhost:3001\n";
        $server->run();
    }
}
