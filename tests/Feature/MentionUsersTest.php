<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function mentioned_users_in_a_reply_are_notified()
    {
    	$sabeel = create('App\User', ['name' => 'Sabeel']);

    	$this->signIn($sabeel);

    	$billy = create('App\User', ['name' => 'Billy']);

    	$thread = create('App\Thread');

    	$reply = make('App\Reply', [
    		'body' => '@Billy look at this.'
    	]);

    	$this->json('post', $thread->path() . '/replies', $reply->toArray());

    	$this->assertCount(1, $billy->notifications);
    }

    /** @test */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'Sabeel']);
        create('App\User', ['name' => 'Sabeel2']);
        create('App\User', ['name' => 'Thomas']);

        $results = $this->json('GET', '/api/users', ['name' => 'Sabeel']);

        $this->assertCount(2, $results->json());
    }
}
