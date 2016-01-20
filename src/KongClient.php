<?php
namespace Dafiti\Kong;

interface KongClient
{
    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function request($method, $uri, array $options = []);
}
