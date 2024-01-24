@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h1>Looking for an employee?</h1>
                <h3>Please create an account</h3>
                <img src="{{ asset('image/register.png') }}" />
            </div>

            <div class="col-md-6">
                <div class="card" id="card">
                    <div class="card-header">Employer Registration</div>
                    <form action="#" method="post" id="registrationForm">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required />

                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" required />
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" required />
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <button class="btn btn-primary" id="btnRegister">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="message"></div>
            </div>
        </div>
    </div>

    <script>
        var url = "{{ route('store.employer') }}";
        document.getElementById("btnRegister").addEventListener("click", function(event) {
            var form = document.getElementById('registrationForm');
            var message = document.getElementById('message');
            message.innerHTML = '';
            var card = document.getElementById('card');

            var button = event.target;
            button.disabled = true;
            button.innerHTML = 'Sending email...';

            var formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }).then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Server error!');
                }
            }).then(data => {
                button.innerHTML = 'Register';
                button.disabled = false;
                message.innerHTML =
                    '<div class="alert alert-success">Registration was successful. Please check your email to verify it</div>';
                card.style.display = 'none';
            }).catch(error => {
                button.innerHTML = 'Register';
                button.disabled = false;
                message.innerHTML =
                    '<div class="alert alert-danger">Registration failed. Please try again</div>';
            });
        });
    </script>
@endsection
