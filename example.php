<?php

require_once 'vendor/autoload.php';

use StringExchange\StringExchange;

$stringExchange = new StringExchange();

// get ticker of default symbol "BTC/AUD"
$res = $stringExchange->ticker();

// get ticker of given symbol
$res = $stringExchange->ticker('ETH/AUD');

// get ticker of all symbols
$res = $stringExchange->tickers();

// get orderbook of "BTC/AUD" with limit of 10
$res = $stringExchange->orderbook();

// get orderbook of "ETH/AUD" with limit of 100
$res = $stringExchange->orderbook('ETH/AUD', 100);


$api_key = "";
$api_secrect = "";

$stringExchange = new StringExchange($api_key, $api_secrect);

// get account balance
$res = $stringExchange->balance();


$order = [
    'price'  => '1000',
    'amount' => '1',
    'symbol' => 'BTC/AUD',
    'type'   => 'limit'
];

// send a sell order
$res = $stringExchange->sell($order);

// send a buy order
$res = $stringExchange->buy($order);


$orderId = 'd0822e38-4ae2-40e1-b731-cc783ea7f060';
// cancel an order, pass the order uuid
$res = $stringExchange->cancel($orderId);

$orderId = '943585b8-8283-4971-96da-0da6a7271bdf';
$res = $stringExchange->order($orderId);
printf(json_encode($res));

