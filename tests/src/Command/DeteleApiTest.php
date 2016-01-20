<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class DeteleApiTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldDeleteApi()
    {
        $response = [];

        $kongClientMock = $this->getMockBuilder(KongClient::class)
            ->setMethods(['request'])
            ->getMockForAbstractClass();

        $kongClientMock->expects($this->once())
            ->method('request')
            ->will($this->returnValue($response));

        $application = new Application();
        $application->add(new DeleteApi($kongClientMock));

        $command = $application->find(DeleteApi::NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'id' => 'foobar'
        ]);
    }
}
