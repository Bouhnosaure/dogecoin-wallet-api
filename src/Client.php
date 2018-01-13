<?php

namespace Bouhnosaure\Dogecoin;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * Http Client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client = null;

    /**
     * JSON-RPC Id.
     *
     * @var int
     */
    protected $rpcId = 0;

    /**
     * Constructs new client.
     *
     * @param mixed $config
     *
     * @return void
     */
    public function __construct($config = [])
    {
        // init defaults
        $config = $this->defaultConfig($this->parseUrl($config));

        $handlerStack = HandlerStack::create();
        $handlerStack->push(
            Middleware::mapResponse(function (ResponseInterface $response) {
                return DogecoindResponse::createFrom($response);
            }),
            'json_response'
        );

        // construct client
        $this->client = new GuzzleHttp([
            'base_uri' => "${config['scheme']}://${config['host']}:${config['port']}",
            'auth' => [
                $config['user'],
                $config['pass'],
            ],
            'verify' => isset($config['ca']) && is_file($config['ca']) ?
                $config['ca'] : true,
            'handler' => $handlerStack,
        ]);
    }

    /**
     * Gets http client config.
     *
     * @param string|null $option
     *
     * @return mixed
     */
    public function getConfig($option = null)
    {
        return (
            isset($this->client) &&
            $this->client instanceof ClientInterface
        ) ? $this->client->getConfig($option) : false;
    }

    /**
     * Gets http client.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets http client.
     *
     * @param  \GuzzleHttp\ClientInterface
     *
     * @return Client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Makes request to Dogecoin Core.
     *
     * @param string $method
     * @param mixed $params
     *
     * @return array
     */
    public function request($method, $params = [])
    {
        try {
            $json = [
                'method' => strtolower($method),
                'params' => (array)$params,
                'id' => $this->rpcId++,
            ];

            $response = $this->client->request('POST', '/', ['json' => $json]);

            if ($response->hasError()) {
                // throw exception on error
                throw new Exceptions\DogecoindException($response->error());
            }

            return $response;
        } catch (RequestException $exception) {
            if ($exception->hasResponse() &&
                $exception->getResponse()->hasError()
            ) {
                throw new Exceptions\DogecoindException($exception->getResponse()->error());
            }

            throw new Exceptions\ClientException(
                $exception->getMessage(),
                $exception->getCode()
            );
        } catch (Exceptions\DogecoindException $exception) {
            throw $exception;
        }
    }

    /**
     * Makes async request to Dogecoin Core.
     *
     * @param string $method
     * @param mixed $params
     * @param callable|null $onFullfiled
     * @param callable|null $onRejected
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function requestAsync(
        $method,
        $params = [],
        callable $onFullfiled = null,
        callable $onRejected = null
    )
    {

        $json = [
            'method' => strtolower($method),
            'params' => (array)$params,
            'id' => $this->rpcId++,
        ];

        $promise = $this->client
            ->requestAsync('POST', '/', ['json' => $json]);

        $promise->then(
            function (ResponseInterface $response) use ($onFullfiled) {
                $error = null;
                if ($response->hasError()) {
                    $error = new Exceptions\DogecoindException($response->error());
                }

                if (is_callable($onFullfiled)) {
                    $onFullfiled($error ?: $response);
                }
            },
            function (RequestException $exception) use ($onRejected) {
                if ($exception->hasResponse() &&
                    $exception->getResponse()->hasError()
                ) {
                    $exception = new Exceptions\DogecoindException(
                        $exception->getResponse()->error()
                    );
                }

                if ($exception instanceof RequestException) {
                    $exception = new Exceptions\ClientException(
                        $exception->getMessage(),
                        $exception->getCode()
                    );
                }

                if (is_callable($onRejected)) {
                    $onRejected($exception);
                }
            }
        );

        return $promise;
    }

    /**
     * Makes request to Dogecoin Core.
     *
     * @param string $method
     * @param array $params
     *
     * @return array|\GuzzleHttp\Promise\PromiseInterface
     */
    public function __call($method, array $params = [])
    {
        $method = str_ireplace('async', '', $method, $count);
        if ($count > 0) {
            return $this->requestAsync($method, ...$params);
        }

        return $this->request($method, $params);
    }

    /**
     * Set default config values.
     *
     * @param array $config
     *
     * @return array
     */
    protected function defaultConfig(array $config = [])
    {
        $defaults = [
            'scheme' => 'http',
            'host' => '127.0.0.1',
            'port' => 22555,
            'user' => '',
            'pass' => '',
        ];

        return array_merge($defaults, $config);
    }

    /**
     * Expand URL config into components.
     *
     * @param mixed $config
     *
     * @return array
     */
    protected function parseUrl($config)
    {
        if (is_string($config)) {
            $allowed = ['scheme', 'host', 'port', 'user', 'pass'];

            $parts = (array)parse_url($config);
            $parts = array_intersect_key($parts, array_flip($allowed));

            if (!$parts || empty($parts)) {
                throw new Exceptions\ClientException('Invalid url');
            }

            return $parts;
        }

        return $config;
    }

    /**
     * Converts amount from shibetoshi to dogecoin.
     *
     * @param int $amount
     *
     * @return float
     */
    public static function toDogecoin($amount)
    {
        return bcdiv((int)$amount, 1e8, 8);
    }

    /**
     * Converts amount from dogecoin to shibetoshi.
     *
     * @param float $amount
     *
     * @return int
     */
    public static function toShibetoshi($amount)
    {
        return bcmul(static::toFixed($amount, 8), 1e8);
    }

    /**
     * Converts amount from dogecoin to Koinu.
     *
     * @param float $amount
     *
     * @return int
     */
    public static function toKoinu($amount)
    {
        return self::toShibetoshi($amount);
    }


    /**
     * Brings number to fixed pricision without rounding.
     *
     * @param float $number
     * @param int $precision
     *
     * @return string
     */
    public static function toFixed($number, $precision = 8)
    {
        $number = $number * pow(10, $precision);

        return bcdiv($number, pow(10, $precision), $precision);
    }
}
