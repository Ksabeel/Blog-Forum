<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card mt-3">
        <div class="card-header">
        	<div class="float-left">
    	        <a href="{{ route('profiles', $reply->owner) }}">
    	            {{ $reply->owner->name }}
    	        </a> said {{ $reply->created_at->diffForHumans() }}...
        	</div>
            
            @auth            
               <favorite :reply="{{ $reply }}"></favorite>
            @endauth
        </div>

        <div class="card-body">
            <div v-if="editing">                
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        @can ('delete', $reply)
            <div class="card-footer">
                <button class="btn btn-sm btn-secondary" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy">Delete</button>

                {{-- <form action="/replies/{{ $reply->id }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form> --}}

            </div>
        @endcan
    </div>
</reply>