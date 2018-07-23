<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_subscribe_to_threads()
    {
    	$this->signIn();

    	$thread = create('App\Thread');

    	$this->post($thread->path() . '/subscriptions');

    	$this->assertCount(1, $thread->subscriptions);
    }
}
