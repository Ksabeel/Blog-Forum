@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-5">
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>

            @foreach ($activities as $date => $activity)
                <div class="mt-3">
                    <h3>{{ $date }}</h3>
                </div>

                @foreach ($activity as $record)
                    @include ("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection