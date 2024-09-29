{{-- Menggunakan layouts admin --}}
@extends('layouts.template')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}">
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" required value="{{ $user->email }}">  
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role_id" id="role" class="form-select" required>
                <option value="{{ $user->role_id }}">User</option>
                <option value="2">User</option>
            </select>
            @error('role_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning">Edit</button>
    </form>
@endsection
