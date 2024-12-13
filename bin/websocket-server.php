<?php
require dirname(__DIR__).'/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Controller\VideoCallController;

// Try a different port (e.g. 8081)
$port = 8081;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new VideoCallController()
        )
    ),
    $port,
    '127.0.0.1' // Use localhost instead of 0.0.0.0
);

echo "WebSocket server started on port $port\n";
$server->run();