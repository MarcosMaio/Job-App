@extends('layouts.admin.main')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <h1>Update a job</h1>
                <div class="row justify-content-center">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                </div>
                <form action="{{ route('job.update', [$id->id]) }}" method="POST" enctype="multipart/form-data">@csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Feature Image</label>
                        <input type="file" name="feature_image" id="feature_image" class="form-control">
                        @if ($errors->has('feature_image'))
                            <div class="error"> {{ $errors->first('feature_image') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ $id->title }}">
                        @if ($errors->has('title'))
                            <div class="error"> {{ $errors->first('title') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control summernote">{{ $id->description }}</textarea>
                        @if ($errors->has('description'))
                            <div class="error"> {{ $errors->first('description') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Roles and Responsibility</label>
                        <textarea id="description" name="roles" class="form-control summernote">{{ $id->roles }}</textarea>
                        @if ($errors->has('roles'))
                            <div class="error"> {{ $errors->first('roles') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Job types</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Fulltime" value="Full-Time"
                                {{ $id->job_type === 'Full-Time' ? 'checked' : '' }}>
                            <label for="Fulltime" class="form-check-label">Full-Time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Parttime" value="Part-Time"
                                {{ $id->job_type === 'Part-Time' ? 'checked' : '' }}>
                            <label for="Parttime" class="form-check-label">Part-Time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="casual" value="Casual"
                                {{ $id->job_type === 'Casual' ? 'checked' : '' }}>
                            <label for="casual" class="form-check-label">Casual</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Contract" value="Contract"
                                {{ $id->job_type === 'Contract' ? 'checked' : '' }}>
                            <label for="Contract" class="form-check-label">Contract</label>
                        </div>
                        @if ($errors->has('job_type'))
                            <div class="error"> {{ $errors->first('job_type') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ $id->address }}">
                        @if ($errors->has('address'))
                            <div class="error"> {{ $errors->first('address') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Salary</label>
                        <input type="text" name="salary" id="salary" class="form-control"
                            value="{{ $id->salary }}">
                        @if ($errors->has('salary'))
                            <div class="error"> {{ $errors->first('salary') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="application_close_date">Application closing date</label>
                        <input type="text" name="application_close_date" id="datepicker" class="form-control"
                            value="{{ $id->application_close_date }}">
                        @if ($errors->has('date'))
                            <div class="error"> {{ $errors->first('date') }} </div>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Update a job</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <style>
        .note-insert {
            display: none !important;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
@endsection
