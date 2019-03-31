<?php

namespace Tests\Feature;

use App\Services\GuzzleService;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class GuzzleServiceTest extends TestCase
{
    /**
     * @test
     */
    function testGetRequest()
    {
        $test_url = 'http://dummy.restapiexample.com/api/v1';
        $guzzle = App::make(GuzzleService::class);
        $result = $guzzle->makeGetRequest($test_url, []);
        $this->assertArrayHasKey('code', $result);
        if ($result['code'] == 200) {

            $this->assertJson($result['data']);
        }
        $this->assertIsArray($result);

    }

    /* /**
      * @test
      */
    function testPostRequest()
    {
        $test_url = 'http://dummy.restapiexample.com/api/v1/create';
        $guzzle = App::make(GuzzleService::class);
        $result = $guzzle->makePostRequest($test_url, [],[]);
        $this->assertArrayHasKey('code', $result);
        if ($result['code'] == 200) {
            $this->assertJson($result['data']);
        }
        $this->assertIsArray($result);
    }
}
