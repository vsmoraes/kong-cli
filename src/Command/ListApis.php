<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListApis extends Command
{
    /**
     * @var KongClient
     */
    private $client;

    public function __construct(KongClient $client)
    {
        $this->client = $client;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('list-apis')
            ->setDescription('List apis registered on kong');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $apis = $this->client->request('GET', '/apis/');

        $tableRows = array_map(function ($api) {
            return [
                $api['id'],
                $api['upstream_url'],
                $api['name'],
                $api['request_host']
            ];
        }, $apis['data']);

        $table = new Table($output);
        $table->setHeaders(['#', 'URL', 'Name', 'Host'])
            ->setRows($tableRows);

        $table->render();
    }
}
