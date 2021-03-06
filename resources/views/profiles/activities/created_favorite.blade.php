@component('profiles.activities.activity')

	@slot('heading')
		<a href="{{ $activity->subject->favorited->path() }}">
			{{ $profileUser->name }} favorite a reply
		</a>
		{{-- <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a> --}}
	@endslot

	@slot('body')
		{{ $activity->subject->favorited->body }}
	@endslot

@endcomponent