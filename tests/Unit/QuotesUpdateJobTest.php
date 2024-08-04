<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\Quote;
use App\Http\Controllers\QuotesController;
use App\Jobs\UpdateQuotes;
use Illuminate\Foundation\Testing\RefreshDatabase;


class QuotesUpdateJobTest extends TestCase
{
 
    //check the api call was successful
    public function test_fetch_quotes()
    {

        $controller = new QuotesController();
        $response = $this->invokeMethod($controller, 'fetchAPIQuotes');
        $this->assertTrue($response->successful());
        $this->assertContains('Ma$e is one of my favorite rappers and I based a lot of my flows off of him', $response->json());
    }

    public function test_quotes_if_quotes_change_database_is_updated()
    {
        $UpdateQuotes = new UpdateQuotes();
        //pass in an array of quotes
        $newQuotes = ['quote1', 'quote2', 'quote3', 'quote4', 'quote5'];
        $this->invokeMethod($UpdateQuotes, 'updateQuotes', [$newQuotes]);
        $this->assertDatabaseHas('quotes', ['quote' => 'quote1']);
        $this->assertDatabaseHas('quotes', ['quote' => 'quote2']);
        $this->assertDatabaseHas('quotes', ['quote' => 'quote3']);
        $this->assertDatabaseHas('quotes', ['quote' => 'quote4']);
        $this->assertDatabaseHas('quotes', ['quote' => 'quote5']);
        //check the number of quotes in the database
        $this->assertEquals(5, Quote::count());
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
