<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Quote;
use App\Jobs\UpdateQuotes;

class QuotesController extends Controller
{
    public function __construct()
    {
        if (Quote::count() === 0) {
            $this->init();
        }
    }

    private function init()
    {
        // Fetch quotes from the API
        $response = $this->fetchAPIQuotes();

        // Check if the API call was successful
        if ($response->successful()) {
            $quotes = $response->json();

            //save the quotes to the database - quote is returned as an array of quotes
            foreach ($quotes as $quote) {
                Quote::create(['quote' => $quote]);
            }
            
        } else {
            // Handle the API call failure
            $error = $response->json();

            return response()->json($error, $response->status());
        }

    }

    public function fetchAPIQuotes()
    {

        // Fetch quotes from the API
        $response = Http::get('https://api.kanye.rest/quotes');

        return $response;

    }

    public function show(){
        // Fetch 5 random quotes from the database
        $quotes = Quote::inRandomOrder()->limit(5)->get();
        // Dispatch the UpdateQuotes job
        UpdateQuotes::dispatch();
        // Return the quotes as a JSON response
        return response()->json($quotes);
    }

}