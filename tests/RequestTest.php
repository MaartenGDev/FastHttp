<?php


namespace App\Test;

use GuzzleHttp\Client;
use PHPUnit_Framework_TestCase;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testApiReturns500ErrorPageIsNotFound(){
        $client = new Client();
        $request = $client->request('GET','http://fasthttp.dev/unknown',[
            'http_errors' => false,
        ]);

        $this->assertEquals(500,$request->getStatusCode());
    }
}