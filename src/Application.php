<?php
namespace Dafiti\Kong;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application as console;

class Application
{
    /**
     * @var Application
     */
    protected static $instance;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var console
     */
    protected $console;

    /**
     * @var array
     */
    protected $config = [];

    private function __construct(ContainerInterface $container, Console $console)
    {
        $this->container = $container;
        $this->console = $console;
    }

    /**
     * @param ContainerInterface|null $container
     * @param console|null $console
     * @return Application
     */
    public static function getInstance(
        ContainerInterface $container = null,
        Console $console = null,
        array $config = []
    ) {
        if (!static::$instance) {
            static::$instance = new static($container, $console);
            static::$instance->setConfig($config);
        }

        return static::$instance;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config = null)
    {
        $this->config = $config;
    }

    /**
     * @param null $index
     * @return array
     */
    public function config($index = null)
    {
        if (!is_null($index)) {
            return $this->config[$index];
        }

        return $this->config;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $commands = $this->config('commands');

        foreach ($commands as $command) {
            $this->console->add($this->container->get($command));
        }

        $this->console->run();
    }
}
