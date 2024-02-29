@extends('layouts.admin.main')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <h1>Post a job</h1>
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
                <form action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                        <label for="title">Feature Image</label>
                        <input type="file" name="feature_image" id="feature_image"
                            class="form-control {{ $errors->has('feature_image') ? 'is-invalid' : '' }}">
                        @if ($errors->has('feature_image'))
                            <div class="error"> {{ $errors->first('feature_image') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title"
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                        @if ($errors->has('title'))
                            <div class="error"> {{ $errors->first('title') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea value={{ old('description') }} id="description" name="description"
                            class="form-control summernote {{ $errors->has('description') ? 'is-invalid' : '' }}"></textarea>
                        @if ($errors->has('description'))
                            <div class="error"> {{ $errors->first('description') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="roles">Roles and Responsibility</label>
                        <textarea value={{ old('roles') }} id="roles" name="roles"
                            class="form-control summernote {{ $errors->has('roles') ? 'is-invalid' : '' }}"></textarea>
                        @if ($errors->has('roles'))
                            <div class="error"> {{ $errors->first('roles') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Job types</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Fulltime" value="Fulltime">
                            <label for="Fulltime" class="form-check-label">Full-time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Parttime" value="Parttime">
                            <label for="Parttime" class="form-check-label">Part-time</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="casual" value="Casual">
                            <label for="Casual" class="form-check-label">Casual</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="job_type" id="Contract" value="Contract">
                            <label for="Contract" class="form-check-label">Contract</label>
                        </div>
                        @if ($errors->has('job_type'))
                            <div class="error"> {{ $errors->first('job_type') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address"
                            class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">
                        @if ($errors->has('address'))
                            <div class="error"> {{ $errors->first('address') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" name="salary" id="salary"
                            class="form-control {{ $errors->has('salary') ? 'is-invalid' : '' }}">
                        @if ($errors->has('salary'))
                            <div class="error"> {{ $errors->first('salary') }} </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="application_close_date">Application closing date</label>
                        <input type="text" name="application_close_date" id="datepicker"
                            class="form-control {{ $errors->has('application_close_date') ? 'is-invalid' : '' }}">
                        @if ($errors->has('application_close_date'))
                            <div class="error"> {{ $errors->first('application_close_date') }} </div>
                        @endif
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success">Post a job</button>
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
        }
    </style>
    @ensection
