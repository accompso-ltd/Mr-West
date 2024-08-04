<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\Quote;
use App\Http\Controllers\QuotesController;
use Illuminate\Foundation\Testing\RefreshDatabase;


class QuotesControllerTest extends TestCase
{
 
    //check the api call was successful
    public function test_fetch_quotes()
    {

        $controller = new QuotesController();
        $response = $this->invokeMethod($controller, 'fetchAPIQuotes');
        $this->assertTrue($response->successful());
        $this->assertContains('Ma$e is one of my favorite rappers and I based a lot of my flows off of him', $response->json());
    }

    public function test_quotes_are_saved_to_database()
    {
        $controller = new QuotesController();
        $this->invokeMethod($controller, 'init');
        //check there is at least 5 results in the database
        $this->assertGreaterThanOrEqual(5, Quote::count());
    }

    public function test_api_middleware()
    {
        $response = $this->get('/api/quotes');
        $response->assertStatus(401);
    }

    public function test_quotes_endpoint()
    {
        $token = env('API_TOKEN');

        // Check if the token is not null or empty
        $this->assertNotEmpty($token, 'API token is not set in the environment variables.');
        // Perform the request with the correct Authorization header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/quotes');

        // Assert that the response status is 200 OK
        $response->assertStatus(200);
    }

    



    /**
     * Helper method to call a protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
   
}
