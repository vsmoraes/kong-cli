<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateApiTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateApi()
    {
        $response = [
            'id' => '4d924084-1adb-40a5-c042-63b19db421d1',
            'name' => 'Mockbin',
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
        $application->add(new CreateApi($kongClientMock));

        $command = $application->find(CreateApi::NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'name' => 'Mockbin',
            'request_host' => 'mockbin.com',
            'request_path' => '',
            'upstream_url' => 'http://mockbin.com',
        ]);

        $expected = <<<EOF
+--------------------------------------+---------+--------------+--------------------+---------------+------------+
| id                                   | name    | request_host | upstream_url       | preserve_host | created_at |
+--------------------------------------+---------+--------------+--------------------+---------------+------------+
| 4d924084-1adb-40a5-c042-63b19db421d1 | Mockbin | mockbin.com  | http://mockbin.com |               | 1422386534 |
+--------------------------------------+---------+--------------+--------------------+---------------+------------+

EOF;

        $this->assertEquals($expected, $commandTester->getDisplay());
    }
}
