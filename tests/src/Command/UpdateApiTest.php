<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateApiTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldUpdateApi()
    {
        $response = [
            'id' => '4d924084-1adb-40a5-c042-63b19db421d1',
            'name' => 'foobar',
            'request_host' => 'mockbin.com',
            'upstream_url' => 'http://mockbin.com',
            'preserve_host' => false,
            'created_at' => 1422386534
        ];

        $kongClientMock = $this->getMockBuilder(KongClient::class)
            ->setMethods(['request'])
            ->getMockForAbstractClass();

        $kongClientMock->expects($this->once())
            ->method('request')
            ->will($this->returnValue($response));

        $application = new Application();
        $application->add(new UpdateApi($kongClientMock));

        $command = $application->find(UpdateApi::NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'id' => '4d924084-1adb-40a5-c042-63b19db421d1',
            '--name' => 'foobar'
        ]);
    }
}
