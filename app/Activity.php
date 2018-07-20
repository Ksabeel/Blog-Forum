<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
    */
    protected $guarded = [];

    public function subject()
    {
    	return $this->morphTo();
    }

    public static function feed($user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->get()
            ->take($take)
            ->groupBy( function($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
