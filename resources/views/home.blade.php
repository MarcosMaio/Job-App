@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Recommended Jobs</h4>
            <div class="dropdown">
                <a href="/" class="btn btn-dark">View all</a>
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Salary
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('index', ['sort' => 'salary_high_to_low']) }}">High
                            to low</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['sort' => 'salary_low_to_high']) }}">Low to
                            high</a></li>
                </ul>

                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Date
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('index', ['date' => 'latest']) }}">Latest</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['date' => 'oldest']) }}">Oldest</a></li>
                </ul>

                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Job type
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('index', ['job_type' => 'full-time']) }}">Full-time</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['job_type' => 'part-time']) }}">Part-time</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['job_type' => 'casual']) }}">Casual</a></li>
                    <li><a class="dropdown-item" href="{{ route('index', ['job_type' => 'contract']) }}">Contract</a></li>
                </ul>


            </div>
        </div>
        <div class="row mt-2 g-1">
            @if (count($jobs) < 1)
                <div class="col-md-12">
                    <div class="alert alert-danger">No jobs found. Please try again</div>
                </div>
            @else
                @foreach ($jobs as $job)
                    <div class="col-md-3">
                        <div class="card p-2">
                            <div class="text-right"> <small
                                    class="badge text-bg-info {{ $job->job_type }}">{{ $job->job_type }}</small> </div>
                            <div class="text-center mt-2 p-3"> <img class="rounded-circle"
                                    src="{{ Storage::url($job->profile->profile_pic) }}" width="100" /> <br>
                                <span class="d-bl>ock font-weight-bold">{{ $job->title }}</span>
                                <hr> <span>{{ $job->profile->name }}</span>
                                <div class="d-flex flex-row align-items-center justify-content-center">
                                    <small class="ml-1">{{ $job->address }}</small>
                                </div>
                                <div class="d-flex justify-content-between mt-3 align-items-center">
                                    <span>{{ $job->salary }}</span>
                                    <a href="{{ route('job.show', [$job->slug]) }}"><button
                                            class="btn btn-dark">{{ $job->profile->user_type === 'seeker' ? 'Apply Now' : 'View Job' }}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <style>
        .card:hover {
            background-color: #EFEFEF;
            transition: 0.2s;
        }

        .Full-Time {
            background-color: green !important;
            color: white;
        }

        .Part-Time {
            background-color: blue !important;
            color: white;
        }

        .Casual {
            background-color: red !important;
            color: white;
        }

        .Contract {
            background-color: purple !important;
            color: white;
        }
    </style>
@endsection
