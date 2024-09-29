{{-- Menggunakan layouts admin --}}
@extends('layouts.template')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <a class="btn btn-primary" href="{{ route('admin.roomType.create') }}">Add Room Type</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Daily Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roomTypes as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->daily_price }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.roomType.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.roomType.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
