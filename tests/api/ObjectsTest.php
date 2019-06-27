<?php

use GuzzleHttp\Client;

class ObjectsTest extends TestCase
{
    private $guzzleClient;

    public function setUp(): void
    {
        parent::setup();
        $this->guzzleClient = new Client();
    }

    public function testObjects()
    {
        $resp = $this->guzzleClient->request('GET', route('get-objects'));
        $arr  = json_decode($resp->getBody(), 1);

        $this->assertEquals('200', $resp->getStatusCode());

        foreach ($arr as $key => $arr_value) {
            $this->checkObjectArrKeys($arr_value);
        }   
    }

    public function testSpecifiedObject()
    {
        $idObject = 1;
        $resp = $this->guzzleClient->request('GET', route('get-object', ['id_object'=>$idObject]));
        $arr  = json_decode($resp->getBody(), 1);

        $this->assertEquals('200', $resp->getStatusCode());
        $this->checkObjectArrKeys($arr);
    }

    /**
     * @expectedException GuzzleHttp\Exception\ClientException
     * @expectedExceptionCode 404
     */
    public function testSpecifiedObjectNotFound()
    {
        $this->guzzleClient->request('GET', route('get-object', ['id_object'=>0])); 
    }

    private function checkObjectArrKeys($arr)
    {
        $this->assertArrayHasKey('id', $arr);
        $this->assertArrayHasKey('title', $arr);
        $this->assertArrayHasKey('brief_description', $arr);
        $this->assertArrayHasKey('description', $arr);
        $this->assertArrayHasKey('latitude', $arr);
        $this->assertArrayHasKey('longitude', $arr);
        $this->assertArrayHasKey('rating_good', $arr);
        $this->assertArrayHasKey('rating_bad', $arr);
        $this->assertArrayHasKey('user_id', $arr);
        $this->assertArrayHasKey('approve', $arr);
        $this->assertArrayHasKey('id_object_type', $arr);
    }
}