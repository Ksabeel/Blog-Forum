@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <avatar-form :user="{{ $profileUser }}"></avatar-form>

            @forelse ($activities as $date => $activity)
                <div class="mt-3">
                    <h3>{{ $date }}</h3>
                </div>

                @foreach ($activity as $record)
                    @include ("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @empty
                <p class="text-center">There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection