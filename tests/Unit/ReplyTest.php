<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_owner()
    {
    	$reply = create('App\Reply');

    	$this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    function it_knows_if_it_was_just_published()
    {
    	$reply = create('App\Reply');
    	
    	$this->assertTrue($reply->wasJustPublished());
    }

    /** @test */
    function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply', [
            'body' => '@Billy mentioned @Sabeel in reply'
        ]);

        $this->assertEquals(['Billy', 'Sabeel'], $reply->mentionedUsers());
    }
}
