<?php
namespace Dafiti\Kong\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListApis extends Command
{
    public function configure()
    {
        $this->setName('list-apis')
            ->setDescription('List apis registered on kong');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
