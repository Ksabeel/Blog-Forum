<?php

namespace App\Http\Controllers;

use App\Spam;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->except(['index']);	
	}

    /**
     * Display a listing of the resource.
     *
     * @param  $channel
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $channel
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function store($channel, Thread $thread, Spam $spam)
    {
        request()->validate(['body' => 'required']);

        $spam->detect(request('body'));

    	$reply = $thread->addReply([
    		'body' => request('body'),
    		'user_id' => auth()->id()
    	]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

    	return back()->with('flash', 'Your reply has been added successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        
        $reply->update(['body' => request('body')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted!']);
        }

        return back();
    }
}
