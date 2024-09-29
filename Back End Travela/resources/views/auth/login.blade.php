{{-- Menggunakan layouts admin --}}
@extends('layouts.auth')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <main class="form-signin">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required/>
                <label for="floatingInput">Email address</label>
                @error('email')
                    <p class="text-danger">{{ $message }}</p> 
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required/>
                <label for="floatingPassword">Password</label>
                @error('password')
                    <p class="text-danger">{{ $message }}</p> 
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">
                Sign in
            </button>
            <a href="{{ route('register') }}">Doesn't have an Account? Create One!</a>
            <p class="mt-5 mb-3 text-muted">&copy; Progress Academy</p>
        </form>
    </main>
@endsection
