<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateApi extends Command
{
    const NAME = 'api:add';
    const DESCRIPTION = 'Register a new api on Kong';

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
                'name',
                InputArgument::REQUIRED,
                'The API name. If none is specified, will default to the request_host or request_path.'
            )
            ->addArgument(
                'request_host',
                InputArgument::REQUIRED,
                'The public DNS address that points to your API. For example, mockbin.com. At least request_host or request_path or both should be specified.'
            )
            ->addArgument(
                'request_path',
                InputArgument::REQUIRED,
                'The public path that points to your API. For example, /someservice. At least request_host or request_path or both should be specified.'
            )
            ->addArgument(
                'upstream_url',
                InputArgument::REQUIRED,
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
        $postData = array_filter([
            'name' => $input->getArgument('name'),
            'request_host' => $input->getArgument('request_host'),
            'request_path' => $input->getArgument('request_path'),
            'upstream_url' => $input->getArgument('upstream_url')
        ]);

        $response = $this->client->request('POST', '/apis/', ['form_params' => $postData]);

        $table = new Table($output);
        $table->setHeaders(array_keys($response))
            ->setRows([array_values($response)]);

        $table->render();
    }
}
