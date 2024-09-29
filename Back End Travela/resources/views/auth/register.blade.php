{{-- Menggunakan layouts admin --}}
@extends('layouts.auth')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <main class="form-signin">
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Register your Account</h1>

            <input type="hidden" name="role_id" value="2">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="John Doe" name="name" />
                <label for="floatingInput">Name</label>
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" />
                <label for="floatingInput">Email Address</label>
                @error('email')
                    <p class="text-danger">{{ $message }}</p> 
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" />
                <label for="floatingPassword">Password</label>
                @error('password')
                    <p class="text-danger">{{ $message }}</p> 
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">
                Register
            </button>
            <a href="{{ route('login') }}">Have an Account? Login</a>
            <p class="mt-5 mb-3 text-muted">&copy; Progress Academy</p>
        </form>
    </main>
@endsection
