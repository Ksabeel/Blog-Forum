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
}
