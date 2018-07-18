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
}
