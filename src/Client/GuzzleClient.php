<?php
namespace Dafiti\Kong\Client;

use Dafiti\Kong\Application;
use Dafiti\Kong\KongClient;
use GuzzleHttp\ClientInterface;

class GuzzleClient implements KongClient
{
    /**
     * @var ClientInterface
     */
    private $guzzle;

    public function __construct(ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function request($method, $uri, array $options = [])
    {
        return json_decode($this->guzzle->request($method, $this->buildUri($uri), $options)
            ->getBody(), true);
    }

    /**
     * @param $endpoint
     * @return string
     */
    protected function buildUri($endpoint)
    {
        $conf = Application::getInstance()->config('kong');

        return $conf['host'] . $endpoint;
    }
}
