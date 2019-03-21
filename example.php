<?php

require_once 'vendor/autoload.php';

use Jinance\Jinance;

$jinance = new Jinance();

// get ticker of default symbol "BTC/AUD"
$res = $jinance->ticker();

// // get ticker of given symbol
$res = $jinance->ticker('ETH/AUD');

// // get ticker of all symbols
$res = $jinance->tickers();

// // get orderbook of "BTC/AUD" with limit of 10
$res = $jinance->orderbook();

// // get orderbook of "ETH/AUD" with limit of 100
$res = $jinance->orderbook('ETH/AUD', 100);


$api_key = "";
$api_secrect = "";

$jinance = new Jinance($api_key, $api_secrect);

// // get account balance
$res = $jinance->balance();


$order = [
    'price'  => '1000',
    'amount' => '1',
    'symbol' => 'BTC/AUD',
    'type'   => 'limit'
];

// // send a sell order
$res = $jinance->sell($order);

// // send a buy order
$res = $jinance->buy($order);


// $orderId = 'd0822e38-4ae2-40e1-b731-cc783ea7f060';
// cancel an order, pass the order uuid
// $res = $jinance->cancel($orderId);

// $orderId = '943585b8-8283-4971-96da-0da6a7271bdf';
// $res = $jinance->order($orderId);

// // get open orders from all symbols with default limit 20
$res = $jinance->openOrders();

// // get open orders from "ETH/AUD" with limit 100
$res = $jinance->openOrders('ETH/AUD', 100);

// // get my trades from "BTC/AUD" with default limit 20
$res = $jinance->myTrades();

// // get my trades from "ETH/AUD" with limit 100
// $res = $jinance->myTrades('BTC/AUD', 1);

printf(json_encode($res));

