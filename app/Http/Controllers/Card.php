<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use App\Person;

class Card extends Controller
{
	/**
	 * Look up a person by database id.
	 *
	 * If the database query fails due to a non-integer id or there
	 * is no user with a given id, returns null, otherwise the corresponding
	 * Person object.
	 *
	 */
	 private static function lookupPerson($id) {
	 	 try {
	 	 	 return Person::findOrFail($id);
	 	 }
	 	 catch (\Exception $_) {
	 	 	return null;	 
	 	 }
	 }

	 /**
	  * Determines whether a non-empty request body IS NOT proper JSON.
	  */
	  private static function badJSONRequest(Request $request) {
	  	  if ( empty($request->getContent()) ) { return false; }
	  	  
	  	  json_decode($request->getContent());
	  	  
	  	  return JSON_ERROR_NONE !== json_last_error();
	  }
	 
	  /**
	   * Checks the authorization secret.
	   */
	   private static function passwordOk($password) {
	   		return strtoupper($password) ===  strtoupper(config('parameters.secrets.password'));   
	   }
	  
	/**
	 * Carries out updating the comments for a person.
	 */
	 public static function doAppendComments($input)
	 {	 	 
      	  // Validate that all the required fields are present.
      	  $validator = Validator::make(
      	  	  $input,
      	  	  array_fill_keys(['password', 'id', 'comments'], ['required']),
      	  	  ['required' => 'Missing key/value for ":attribute"']
      	  );

      	  if ( $validator->fails() )
      	  {
      	  	  $message = Arr::first($validator->errors()->all());

      	  	  return response($message, 422);   
      	  }
      	  
      	  // Check the authorization secret is correct.
      	  if ( ! self::passwordOk($input['password']) )
      	  {
      	  	return response('Invalid password', 401);  
      	  }
      	  
      	  // Guard that the identifier is numeric.
      	  if ( ! is_numeric($input['id']) ) {
      	  	  return response('Invalid id', 422);
      	  }
      	  
     	 $person = self::lookupPerson($input['id']);
     	 
     	 if ( is_null($person) )
     	 {
     	 	return response('No such user (1)', 404);	 
     	 }	 	 
	 	 
     	 $person->comments .= PHP_EOL . $input['comments'];
     	 $person->save();
     	 
	 	 return response('OK', 200);
	 }
	   
    /**
     * Display a card for a person.
     *
     * @param string $id The identifier (from database)
     * @return View
     */
     public function display($id) {
     	 $person = self::lookupPerson($id);
     	 
     	 if ( is_null($person) )
     	 {
     	 	return response('No such user (2)', 404);	 
     	 }
     	 
     	 return view('card')->with('person', $person);	 
     }
     
     /**
      * Update comments on an existing card for a person.
      *
      * Requires a secret (password/token) for authorization.
      */
      public function appendComments(Request $request) {
      	  
      	  // Guard on improper JSON content.
      	  if ( self::badJSONRequest($request) ) {
      	  	return response('Invalid POST JSON', 422);	  
      	  }
      	  
      	  $input = empty($request->getContent()) ? $request->all() : $request->json()->all();
      	        	  
      	  return self::doAppendComments($input);
      }
}
