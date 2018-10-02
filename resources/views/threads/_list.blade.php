@forelse ($threads as $thread)
    <div class="card mb-3">

        <div class="card-header">
            <div class="float-left">
                <h5>
                    Posted by: <a href="{{ route('profiles', $thread->creator) }}">
                        {{ $thread->creator->name }}
                    </a>
                </h5>

                <a href="{{ $thread->path() }}">
                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                        
                        <strong>{{ $thread->title }}</strong>
                    @else

                        {{ $thread->title }}

                    @endif
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

        <div class="card-footer">
            {{ $thread->visits()->count() }} Visits
        </div>

    </div>
@empty
    <p class="text-center">There are no relevant results at this time.</p>
@endforelse