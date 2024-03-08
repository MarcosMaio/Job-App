@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-md-8">
                <h3>Applied jobs</h3>
                @foreach ($users as $user)
                    @foreach ($user->listings as $listing)
                        <div class="card mt-5 px-4 py-1">
                            <div class="row g-0">
                                <div class="col-auto">
                                    @if ($user->profile_pic)
                                        <img src="{{ Storage::url($listing->profile->profile_pic) }}" class="rounded-circle"
                                            style="width: 150px;" alt="Profile Picture">
                                    @else
                                        <img src="https://placehold.co/400" class="rounded-circle" style="width: 150px;"
                                            alt="Profile Picture">
                                    @endif
                                </div>
                                <div class="col mt-3">
                                    <div class="card-body">
                                        <h4 class="card-title">{{$listing->profile->name}}</h4>
                                        <h6 class="card-subtitle">{{ $listing->title }}</h6>
                                        <p class="card-text font">
                                            Applied: {{ date('Y-m-d', strtotime($listing->pivot->created_at)) }} </p>
                                    </div>
                                </div>
                                <div class="col-auto d-flex align-self-center">
                                    <a href="{{ route('job.show', [$listing->slug]) }}" class="btn btn-dark">View</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
