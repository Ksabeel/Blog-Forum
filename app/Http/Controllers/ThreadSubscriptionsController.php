<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    /**
     * Create a new ThreadSubscriptionsController instance.
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  $channel
	 * @param  \App\Thread  $thread
	 * @return \Illuminate\Http\Response
	 */
    public function store($channel, Thread $thread)
    {
    	$thread->subscribe();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $channel
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
    	$thread->unsubscribe();
    }
}
