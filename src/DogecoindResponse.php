<?php

namespace Bouhnosaure\Dogecoin;

use ArrayAccess;
use Countable;
use JsonSerializable;
use Serializable;

use Psr\Http\Message\ResponseInterface;

class DogecoindResponse implements ResponseInterface, ArrayAccess, Countable, Serializable, JsonSerializable
{
    use MessageTrait, ResponseArrayTrait, ReadOnlyArrayTrait, SerializableContainerTrait;

    /**
     * Response instance.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * Data container.
     *
     * @var array
     */
    protected $container = [];

    /**
     * Current key.
     *
     * @var string
     */
    protected $current;

    /**
     * Constructs new json response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->container = json_decode($response->getBody(), true);
    }

    /**
     * Gets raw response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Sets response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return static
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Checks if response has error.
     *
     * @return bool
     */
    public function hasError()
    {
        return isset($this->container['error']);
    }

    /**
     * Gets error object.
     *
     * @return object|null
     */
    public function error()
    {
        if ($this->hasError()) {
            return $this->container['error'];
        }
    }

    /**
     * Checks if response has result.
     *
     * @return bool
     */
    public function hasResult()
    {
        return isset($this->container['result']);
    }

    /**
     * Gets result array.
     *
     * @return array|null
     */
    public function result()
    {
        if ($this->hasResult()) {
            return $this->container['result'];
        }
    }

    /**
     * Get response status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * @param int $code
     * @param string $reasonPhrase
     *
     * @return static
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $new = clone $this;

        return $new->setResponse(
            $this->response->withStatus($code, $reasonPhrase)
        );
    }

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->response->getReasonPhrase();
    }

    /**
     * Creates new json response from response interface object.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Bouhnosaure\Dogecoin\DogecoindResponse
     */
    public static function createFrom(ResponseInterface $response)
    {
        return new self($response);
    }
}
