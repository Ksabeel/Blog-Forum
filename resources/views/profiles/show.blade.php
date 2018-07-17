@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-5">
        {{ $profileUser->name }}
        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
    </h1>

    @foreach ($threads as $thread)
        <div class="card mt-4">
            <div class="card-header">
                {{ $thread->title }}
            </div>

            <div class="card-body">
                {{ $thread->body }}
            </div>
        </div>
    @endforeach
    
    <div class="mt-4">
        {{ $threads->links() }}
    </div>
</div>
@endsection