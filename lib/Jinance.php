<?php

namespace Jinance;

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class JinanceAPIException extends \ErrorException {};

class Jinance
{
    private $key;     // API key
    private $secret;  // API secret
    private $url = "https://api.jinance.com.au/api/v1/";     // API base URL
    private $client;    // http request

    function __construct(string $key = "", string $secret = "")
    {
        $this->key = $key;
        $this->secret = $secret;
        if (!$this->client) {
            $this->client = new \GuzzleHttp\Client();
        }
    }

    public function ticker(string $symbol = 'BTC/AUD')
    {
        return $this->query_public("ticker/24hr", compact('symbol'));
    }

    public function tickers()
    {
        return $this->query_public("ticker/24hr");
    }

    public function orderbook(string $symbol = 'BTC/AUD', $limit = 10)
    {
        return $this->query_public("depth", compact('symbol', 'limit'));
    }

    public function balance()
    {
        return json_decode($this->post('GET', 'account'), true);
    }

    public function sell(array $order)
    {
        $order['side'] = 'ask';
        return json_decode($this->post(
            'POST',
            'order',
            $order
        ), true);
    }

    public function buy(array $order)
    {
        $order['side'] = 'bid';
        return json_decode($this->post(
            'POST',
            'order',
            $order
        ), true);
    }

    public function cancel(string $orderId)
    {
        $result = $this->post(
            'DELETE',
            'order',
            ['orderUuid' => $orderId]
        );
        return ["result" => "OK"];
    }


    public function order(string $orderId)
    {
        return json_decode($this->post(
            'GET',
            'order',
            ['orderUuid' => $orderId]
        ), true);
    }


    public function openOrders(string $symbol = '', int $limit = 20)
    {
        return json_decode($this->post(
            'GET',
            'openOrders',
            compact('symbol', 'limit')
        ), true);
    }

    public function myTrades(string $symbol = 'BTC/AUD', int $limit = 20)
    {
        return json_decode($this->post(
            'GET',
            'myTrades',
            compact('symbol', 'limit')
        ), true);
    }

    private function query_public(string $method, array $parameters = array(), string $verb = 'GET')
    {
        $url = $this->url.$method;
        if (!empty($parameters)) {
            $url .= "?".http_build_query($parameters);
        }
        $response = $this->client->request($verb, $url);
        return json_decode($response->getBody()->getContents(), true);
    }

    private function post(string $httpMethod, string $method, array $apiParams = [])
    {
        $params = $apiParams ?? [];
        $params['timestamp'] = $this->createNonce();

        $requestString = http_build_query($params, '', '&');
        $hash = hash_hmac(
            'sha256',
            $requestString,
            $this->secret,
            false
        );
        $response = $this->client->request(
            $httpMethod,
            "{$this->url}{$method}?{$requestString}&signature={$hash}",
            ["headers" => ['X-STRING-APIKEY' => $this->key]]
        );
        return $response->getBody()->getContents();
    }

    protected function generateOrderParams(array $order): array
    {
        return [
            'symbol' => $order['symbol'],
            'side'   => $order['side'],
            'type'   => $order['type'] ?? 'limit',
            'price'  => $order['price'],
            'amount' => $order['amount']
        ];
    }

    private function createNonce(int $length = 13)
    {
        $length = min(max($length, 10), 18);
        $mt = explode(' ', microtime());
        $nonce = $mt[1].substr($mt[0], 2, $length - 10);
        return $nonce;
    }
}
