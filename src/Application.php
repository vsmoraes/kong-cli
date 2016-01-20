<?php
namespace Dafiti\Kong;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application as console;
use Symfony\Component\Yaml\Yaml;

class Application
{
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

    public function __construct(ContainerInterface $container, Console $console)
    {
        $this->container = $container;
        $this->console = $console;
    }

    /**
     * @param string $filename
     */
    protected function loadConfig($filename = 'app.yml')
    {
        if (!empty($this->config)) {
            return;
        }

        $config = Yaml::parse(file_get_contents(CONFIG_PATH . $filename));

        $this->setConfig($config);
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
        $this->loadConfig();
        $commands = $this->config('commands');

        foreach ($commands as $command) {
            $this->console->add($this->container->get($command));
        }

        $this->console->run();
    }
}
