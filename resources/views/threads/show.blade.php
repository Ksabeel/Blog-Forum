@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <a href="{{ route('profiles', $thread->creator) }}">
                            {{ $thread->creator->name }}
                        </a> posted: {{ $thread->title }}
                    </div>
                    
                    @auth
                        <div class="float-right">
                            <form action="{{ $thread->path() }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-link">Delete Thread</button>
                            </form>
                        </div>
                    @endauth
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
            
            <div class="mt-4">
                <p>Comments</p>
                @foreach ($replies as $reply)
                    @include ('threads.reply')
                @endforeach
            </div>

            <div class="mt-3">
                {{ $replies->links() }}
            </div>

            @auth
                <form action="{{ $thread->path() . '/replies' }}" method="POST" class="mt-5">
                    @csrf
                    
                    <div class="form-group">
                        <textarea name="body" id="body" rows="5" placeholder="Something to say?" class="form-control"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-outline-primary" type="submit">Post</button>
                    </div>
                </form>

            @else
                <p class="text-center mt-5">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
            @endauth
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was published {{ $thread->created_at->diffForHumans() }} by
                    <a href="{{ route('profiles', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    and currently has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
