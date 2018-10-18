@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
<thread-view :thread="{{ $thread }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" class="rounded-circle mr-1" width="30">
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
                        
                        <div class="mt-3 d-inline-flex">
                            <subscribe-button 
                                :thread-subscribe="{{ json_encode($thread->isSubscribedTo) }}"
                                v-if="signedIn">
                            </subscribe-button>

                            <button class="btn btn-outline-primary ml-2" 
                                    v-if="authorize('isAdmin')"
                                    @click="toggleLock"
                                    v-text="locked ? 'Unlock' : 'Lock'"
                                    v-cloak></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>

@endsection