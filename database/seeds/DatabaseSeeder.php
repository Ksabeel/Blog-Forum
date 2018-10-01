<?php

use App\Thread;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	Thread::truncate();
    	
        $this->call(ThreadSeeder::class);
    }
}
