<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Card;

class AppendComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appendComments {id} {commentWords*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Appends a line of comments to the card of a given person';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$input = [
    		'id' => $this->argument('id'),
    		'password' => config('parameters.secrets.password'),
    		'comments' => implode(' ', $this->argument('commentWords'))
    	];
    	
    	$response = Card::doAppendComments($input);
    	
    	if ( $response->isSuccessful() ) {
    		$this->info($response->getContent());
    	} else {
    		$this->error($response->getContent());	
    	}
    }
}
