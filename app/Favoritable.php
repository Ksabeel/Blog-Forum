<?php

namespace App;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting( function($model) {
            $model->favorites->each->delete();
        });
    }

	/**
     * A reply can be favorited.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
    */
    public function favorites()
    {
    	return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorite the current reply.
     *
     * @return Model
    */
    public function favorite()
    {
    	$attributes = ['user_id' => auth()->id()];

    	if (! $this->favorites()->where($attributes)->exists()) {
	    	return $this->favorites()->create($attributes);
    	}
    }

    /**
     * Determine if the current reply has been unfavorited.
     *
     * @return Boolean
    */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return Boolean
    */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Get the favorited attribute.
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Get the favorites count.
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}