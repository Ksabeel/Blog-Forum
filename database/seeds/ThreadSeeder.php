<?php

use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thread = factory('App\Thread', 50)->create();

    	$thread->each( function ($thread) {
    		factory('App\Reply', 10)->create(['thread_id' => $thread->id]);
    	});
    }
}
