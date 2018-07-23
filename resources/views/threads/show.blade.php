@extends('layouts.app')

@section('content')
<thread-view :thread-replies-count="{{ $thread->replies_count }}" inline-template>
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
                        
                        @can ('delete', $thread)
                            <div class="float-right">
                                <form action="{{ $thread->path() }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-link">Delete Thread</button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                
                <div class="mt-4">
                    <p>Comments</p>
                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="{{ route('profiles', $thread->creator) }}">{{ $thread->creator->name }}</a>
                        and currently has <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>

@endsection