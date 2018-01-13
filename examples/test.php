<?php

require __DIR__ . '/../vendor/autoload.php';

use Bouhnosaure\Dogecoin\Client as DogecoinClient;

//$dogecoind = new DogecoinClient('http://rpcuser:rpcpassword@localhost:8332/');
//$dogecoind = new DogecoinClient('http://localhost:44556/');

$dogecoind = new DogecoinClient([
    'scheme' => 'http',                 // optional, default http
    'host' => 'localhost',            // optional, default localhost
    'port' => 44555,                   // optional, default 22555 / testnet 44555
    'user' => 'user',              // required
    'pass' => 'password',          // required
    'ca' => ''  // optional, for use with https scheme
]);

$result = $dogecoind->getBalance();

var_dump($result->get());