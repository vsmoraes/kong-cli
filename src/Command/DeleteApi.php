<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteApi extends Command
{
    const NAME = 'api:delete';
    const DESCRIPTION = 'Delete an api from Kong';

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
            ->setDescription(static::DESCRIPTION)
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'ID or name of the api to be deleted'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->client->request('DELETE', '/apis/' . $input->getArgument('id'));
    }
}
