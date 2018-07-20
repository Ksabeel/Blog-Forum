<div id="reply-{{ $reply->id }}" class="card mt-3">
    <div class="card-header">
    	<div class="float-left">
	        <a href="{{ route('profiles', $reply->owner) }}">
	            {{ $reply->owner->name }}
	        </a> said {{ $reply->created_at->diffForHumans() }}...
    	</div>

    	<div class="float-right">
    		<form action="/replies/{{ $reply->id }}/favorites" method="POST">
    			@csrf
    			<button type="submit" class="btn btn-sm btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
    				{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
    			</button>
    		</form>
    	</div>
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>