<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Displays the card for a user selected by database identifier.
 */
Route::get('/user/{id}', 'Card@display');

/**
 * Adds a new line to the comments on a person's card.
 *
 * The post may either have a HTML form Content-Type or be raw JSON.
 * In either case, the following parameters must be present.
 *
 * @param int id
 * @param string password
 * @param string comments
 */
Route::post('/', 'Card@appendComments');

/**
 * We respond with a no user message if we don't recognize the route,
 * as the legacy controller does.
 */
Route::fallback(function () {
	return response('No such user (3)', 404);
});
