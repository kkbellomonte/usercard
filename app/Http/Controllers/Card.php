<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Card extends Controller
{
    /**
     * Display a card for a person.
     *
     * @param string $id The identifier (from database)
     * @return View
     */
     public function display($id) {
     	 $person = \App\Person::findOrFail((int) $id);
     	 
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
