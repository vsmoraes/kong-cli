<?php

return [
    \Dafiti\Kong\KongClient::class => DI\object(\Dafiti\Kong\Client\GuzzleClient::class),
    \GuzzleHttp\ClientInterface::class => DI\object(\GuzzleHttp\Client::class),
    \Dafiti\Kong\Application::class => \Dafiti\Kong\Application::getInstance()
];
