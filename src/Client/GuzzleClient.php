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

    /**
     * @var array
     */
    private $config;

    public function __construct(ClientInterface $guzzle, Application $application)
    {
        $this->guzzle = $guzzle;
        $this->config = $application->config('kong');
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return array
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
        return $this->config['host'] . $endpoint;
    }
}
