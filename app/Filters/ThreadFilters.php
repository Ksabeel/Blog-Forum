<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
	protected $filters = ['by', 'papular', 'unanswered'];

	/**
	 * Filter the query name by a username.
	 * 
	 * @param string $username
	 *@return mixed
	*/
	protected function by($username)
	{
		$user = User::where('name', $username)->firstOrFail();

		return $this->builder->where('user_id', $user->id);
	}

	/**
	 * Filter the query according to most papular threads.
	 * 
	 *@return $this
	*/
	protected function papular()
	{
		$this->builder->getQuery()->orders = [];
		
		return $this->builder->orderBy('replies_count', 'desc');
	}

	protected function unanswered()
	{
		return $this->builder->where('replies_count', 0);
	}
}