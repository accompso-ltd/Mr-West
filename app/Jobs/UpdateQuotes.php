<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\QuotesController;
use App\Models\Quote;

class UpdateQuotes implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //run fetchAPIQuotes from QuoteController
        $QuoteController = new QuotesController();
        $apiQuotes = $QuoteController->fetchAPIQuotes();

        // list all quotes from the database
        $Quotes = Quote::all()->pluck('quote')->toArray();

        //compare the quotes from the API with the quotes from the database using array_diff
        $diff = array_diff($apiQuotes->json(), $Quotes);

        if(count($diff) > 0){
            //update the quotes in the database
            $this->updateQuotes($apiQuotes);
        }

    }

    private function updateQuotes($apiQuotes)
    {
        //truncate the quotes table 
        //assuming the api is our single source of truth
        Quote::truncate();
       
        //save the quotes to the database - quote is returned as an array of quotes
        foreach ($apiQuotes as $quote) {
            Quote::create(['quote' => $quote]);
        }
    }
}
