<?php
namespace Dafiti\Kong;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application as ConsoleApp;
use Symfony\Component\Console\Command\Command;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Application::destroyInstance();
    }

    public function testShouldCreateApplicationInstace()
    {
        $containerMock = $this->getMockBuilder(ContainerInterface::class)
            ->getMock();

        $consoleMock = $this->getMockBuilder(ConsoleApp::class)
            ->getMock();


        $this->assertInstanceOf(Application::class, Application::getInstance($containerMock, $consoleMock));
    }

    public function testApplicationShouldRun()
    {
        $commands = [new Command('foobar')];

        $containerMock = $this->getMockBuilder(ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();

        $containerMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($commands[0]));

        $consoleMock = $this->getMockBuilder(ConsoleApp::class)
            ->setMethods(['add', 'run'])
            ->getMock();

        $consoleMock->expects($this->once())
            ->method('add')
            ->with($commands[0])
            ->will($this->returnValue(null));

        $application = Application::getInstance($containerMock, $consoleMock);

        $application->setConfig([
            'commands' => $commands
        ]);

        $application->run();
    }
}
