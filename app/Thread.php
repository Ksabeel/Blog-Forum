<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
    */
    protected $guarded = [];

    protected $with = ['creator', 'channel'];
    
    /**
     * Boot the model.
    */
    public static function boot()
    {
        parent::boot();

        static::deleting( function($thread) {
            $thread->replies->each->delete();
        });
    }

    /**
     * Get string path for the thread.
     *
     * @return string
    */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
    
    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

    /**
     * A thread belongs to a creator.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function creator()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread belongs to a channel.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     * @return Reply
     * @return Model
    */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);        
    }

    /**
     * Apply all relevant thread filter.
     *
     * @param Builder $query
     * @param ThreadFilter $filter
     * @return Builder
    */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
