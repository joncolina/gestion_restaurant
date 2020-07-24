<?php
/**
 * Incluimos los archivos escenciales
 */
require_once(__DIR__."/constantes.php");
require_once(__DIR__."/funciones.php");
require_once(__DIR__."/APIs/vendor/autoload.php");
IncluirCarpeta(BASE_DIR."_core/utils");
IncluirCarpeta(BASE_DIR."_core/modelos");
require_once(BASE_DIR . "_core/APIs/database/mysql.php");
require_once(BASE_DIR . "_core/APIs/database/sqlite3.php");
IncluirCarpeta(BASE_DIR . "_core/APIs/monitoreo");

/**
 * 
 */
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

/**
 * 
 */
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Monitoreo()
        )
    ),
    SOCKET['PORT']
);

$server->run();
?>