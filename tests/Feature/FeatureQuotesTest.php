<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class FeatureQuotesTest extends TestCase
{



    public function test_api_shows_5_quotes()
    {
        //get ithe auth header
       

        $client = new Client();
        $token = env('API_TOKEN');

        $this->assertNotEmpty($token, 'API token is not set in the environment variables.');
        $response = $client->request('GET', env('BASE_URL').'/api/quotes', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
    
        $this->assertEquals(200, $response->getStatusCode());
    
        $data = json_decode($response->getBody(), true);
        $this->assertCount(5, $data);
    }

    public function test_api_middleware()
    {
        $response = $this->get('/api/quotes');
        $response->assertStatus(401);
    }




      
}
