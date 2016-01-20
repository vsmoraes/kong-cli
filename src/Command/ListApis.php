<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListApis extends Command
{
    const NAME = 'api:list';
    const DESCRIPTION = 'List apis registered on kong';

    /**
     * @var KongClient
     */
    private $client;

    public function __construct(KongClient $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    /**
     * Configure command
     */
    public function configure()
    {
        $this->setName(static::NAME)
            ->setDescription(static::DESCRIPTION);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->request('GET', '/apis/');

        $headers = [];
        $rows = [];

        foreach ($response['data'] as $api) {
            if (empty($headers)) {
                $headers = array_keys($api);
            }

            $rows[] = array_values($api);
        }

        $table = new Table($output);

        $table->setHeaders($headers)
            ->setRows($rows)
            ->render();
    }
}
