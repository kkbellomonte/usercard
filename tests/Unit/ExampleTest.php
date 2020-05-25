<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

use App\Http\Controllers\Card;

class ExampleTest extends TestCase
{	 
    /**
     * Test bad JSON is rejected.
     *
     * @return void
     */
    public function testBadJsonRejected()
    {
    	$request = Request::create('/', 'POST', [], [], [], [], 'bad-json');
    	
        $this->assertTrue(Card::badJSONRequest($request));
    }
    
    /**
     * Test good JSON is accepted.
     *
     * @return void
     */
    public function testGoodJsonAccepted()
    {
    	$request = Request::create('/', 'POST', [], [], [], [], '{"id": 44}');
    	
        $this->assertFalse(Card::badJSONRequest($request));
    }
    
}
