{{-- Menggunakan layouts admin --}}
@extends('layouts.template')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <a class="btn btn-primary" href="{{ route('admin.admin.create') }}">Add Admin</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admin as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role->name }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.admin.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.admin.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
