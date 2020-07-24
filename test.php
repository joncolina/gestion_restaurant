<?php
require_once(__DIR__."/_core/APIs/vendor/autoload.php");
$client = new WebSocket\Client("ws://localhost:9000/");
$client->send("Hello WebSocket.org!");
echo $client->receive();
$client->close();
?>