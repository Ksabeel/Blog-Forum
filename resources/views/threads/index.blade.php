@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse ($threads as $thread)
                <div class="card mb-3">

                    <div class="card-header">
                        <div class="float-left">
                            <a href="{{ $thread->path() }}">
                                <h4>{{ $thread->title }}</h4>
                            </a>
                        </div>

                        <div class="float-right">
                            <a href="{{ $thread->path() }}">
                                {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>

                </div>
            @empty
                <p class="text-center">There are no relevant results at this time.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
