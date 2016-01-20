<?php
namespace Dafiti\Kong\Command;

use Dafiti\Kong\KongClient;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ListApisTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldConfigureCommand()
    {
        $kongClientMock = $this->getMockBuilder(KongClient::class)
            ->getMockForAbstractClass();

        $command = new ListApis($kongClientMock);
        $command->configure();

        $this->assertEquals(ListApis::NAME, $command->getName());
        $this->assertEquals(ListApis::DESCRIPTION, $command->getDescription());
    }

    public function testShouldListApisAndDisplayOnTable()
    {
        $response = [
            'data' => [
                [
                    'id' => 1,
                    'upstream_url' => 'http://foo.bar',
                    'name' => 'Foo bar',
                    'request_host' => 'foo.bar'
                ]
            ]
        ];

        $kongClientMock = $this->getMockBuilder(KongClient::class)
            ->setMethods(['request'])
            ->getMockForAbstractClass();

        $kongClientMock->expects($this->once())
            ->method('request')
            ->will($this->returnValue($response));

        $application = new Application();
        $application->add(new ListApis($kongClientMock));

        $command = $application->find(ListApis::NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $expected = <<<EOF
+---+----------------+---------+---------+
| # | URL            | Name    | Host    |
+---+----------------+---------+---------+
| 1 | http://foo.bar | Foo bar | foo.bar |
+---+----------------+---------+---------+

EOF;

        $this->assertEquals($expected, $commandTester->getDisplay());
    }
}
