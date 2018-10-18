<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
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

    /**
     * Get the relations for threads with the $with property.
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * Get this property with $appends for json response.
     * @var array
     */
    protected $appends = ['isSubscribedTo'];

    protected $casts = [
        'locked' => 'boolean'
    ];

    /**
     * Get the route key name for Channel.
     *
     * @return string
    */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * Boot the model.
    */
    public static function boot()
    {
        parent::boot();

        static::deleting( function($thread) {
            $thread->replies->each->delete();
        });

        static::created( function($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

    /**
     * Get string path for the thread.
     *
     * @return string
    */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }
    
    /**
     * A thread can have many replies.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
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
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
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

    /**
     * A thread hasMany subscribers
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Subscribe a user to the current thread.
     *
     * @param int|null $userId
    */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
    */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
    */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();   
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * Set the propper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . md5($this->id);
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply($reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }
}
