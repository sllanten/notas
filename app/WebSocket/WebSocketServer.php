<?php

namespace App\WebSocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use React\EventLoop\Factory;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct(){
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn){
        echo "Nuevo cliente conectado ({$conn->resourceId})\n";
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg){
        echo "Mensaje recibido: $msg\n";

        // Enviar el mensaje a todos los clientes conectados
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn){
        echo "Cliente {$conn->resourceId} desconectado\n";
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}
