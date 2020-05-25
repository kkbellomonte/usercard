<?php

use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Person::truncate();
        \App\Person::create([
        	'name' => 'John Smith',
        	'comments' => 'Director'
        ]);
    }
}
