<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
      	  return response('OK');
      }
}
