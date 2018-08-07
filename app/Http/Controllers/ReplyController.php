<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
     * @param  \App\Inspections\Spam  $spam
     * @return \Illuminate\Http\Response
     */
    public function store($channel, Thread $thread)
    {
        if (Gate::denies('create', new Reply)) {
            return response(
                'You are posting too frequently. Please take a break. :)', 422
            );
        }

        try {

            request()->validate(['body' => ['required', new SpamFree]]);

        	$reply = $thread->addReply([
        		'body' => request('body'),
        		'user_id' => auth()->id()
        	]);
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }
        
        return $reply->load('owner');
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

        try {
            
            request()->validate(['body' => new SpamFree]);

            $reply->update(['body' => request('body')]);
        } catch(\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }
 
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
