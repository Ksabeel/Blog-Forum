<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
    */
    protected $guarded = [];

    /**
     * A user belongs to a thread-subscription.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    /**
     * A thread belongs to a thread-subscription.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
