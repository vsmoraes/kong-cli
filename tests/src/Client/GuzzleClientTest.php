<?php
namespace Dafiti\Kong\Client;

use Dafiti\Kong\Application;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleClientTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldMakeARequest()
    {
        $responseData = [
            'data' => [
                'foo' => 'bar'
            ]
        ];

        $responseMock = $this->getMockBuilder(ResponseInterface::class)
            ->setMethods(['getBody'])
            ->getMockForAbstractClass();

        $responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(json_encode($responseData)));

        $guzzleMock = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['request'])
            ->getMockForAbstractClass();

        $guzzleMock->expects($this->once())
            ->method('request')
            ->will($this->returnValue($responseMock));

        $appMock = $this->getMockBuilder(Application::class)
            ->setMethods(['config'])
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->expects($this->once())
            ->method('config')
            ->with('kong')
            ->will($this->returnValue(['host' => 'kong.dev']));

        $client = new GuzzleClient($guzzleMock, $appMock);

        $result = $client->request('GET', '/foo', []);

        $this->assertEquals($responseData, $result);
    }
}
