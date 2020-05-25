<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
	use RefreshDatabase;
	
    /**
     * Test that we have a card for our seeded person.
     *
     * @return void
     */
    public function testHavePerson()
    {
    	$this->seed();
    	
        $response = $this->get('/user/1');

        $response->assertStatus(200);
    }
    
    /**
     * Test that a missing person gives a 404 status code.
     *
     * @return void
     */
     public function testMissingPerson()
     {
     	$this->seed();
     	
     	$response = $this->get('/user/2');
     	
     	$response->assertStatus(404);
     }
     
     /**
      * Test adding a comment via POST.
      *
      * @return void
      */
      public function testAddCommentByPost()
      {
      	$this->seed();
      	
      	$comment = 'Another line';
      	
      	$response = $this->post('/', [
      			'id' => 1,
      			'password' => config('parameters.secrets.password'),
      			'comments' => $comment
      		]);
      	
      	$response
      		->assertOk()
      		->assertSee('OK')
      	;
      	
      	$response = $this->get('/user/1');
      	
      	$response->assertSee($comment);
      }
}
