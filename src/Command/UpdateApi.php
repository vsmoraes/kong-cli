<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateApi extends Command
{
    const NAME = 'api:update';
    const DESCRIPTION = 'Update an existing api';

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
                'The API id or name'
            )
            ->addOption(
                'name',
                null,
                InputOption::VALUE_OPTIONAL,
                'The API name. If none is specified, will default to the request_host or request_path.'
            )
            ->addOption(
                'request_host',
                null,
                InputOption::VALUE_OPTIONAL,
                'The public DNS address that points to your API. For example, mockbin.com. At least request_host or request_path or both should be specified.'
            )
            ->addOption(
                'request_path',
                null,
                InputOption::VALUE_OPTIONAL,
                'The public path that points to your API. For example, /someservice. At least request_host or request_path or both should be specified.'
            )
            ->addOption(
                'upstream_url',
                null,
                InputOption::VALUE_OPTIONAL,
                'The base target URL that points to your API server, this URL will be used for proxying requests. For example, https://mockbin.com.'
            )
            ->addOption(
                'strip_request_path',
                null,
                InputOption::VALUE_NONE,
                'Strip the request_path value before proxying the request to the final API. For example a request made to /someservice/hello will be resolved to upstream_url/hello. By default is false.'
            )
            ->addOption(
                'preserve_host',
                null,
                InputOption::VALUE_NONE,
                'Preserves the original Host header sent by the client, instead of replacing it with the hostname of the upstream_url. By default is false.'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $apiId = $input->getArgument('id');

        $data = array_filter([
            'name' => $input->getOption('name'),
            'request_host' => $input->getOption('request_host'),
            'request_path' => $input->getOption('request_path'),
            'strip_request_path' => $input->getOption('strip_request_path'),
            'preserve_host' => $input->getOption('preserve_host'),
            'upstream_url' => $input->getOption('upstream_url')
        ]);

        if (empty($data)) {
            throw new RuntimeException('Not enough arguments, you need to update at least one field');
        }

        $response = $this->client->request('PATCH', '/apis/' . $apiId, ['form_params' => $data]);

        $table = new Table($output);
        $table->setHeaders(array_keys($response))
            ->setRows([array_values($response)]);

        $table->render();
    }
}
