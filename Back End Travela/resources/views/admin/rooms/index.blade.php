{{-- Menggunakan layouts admin --}}
@extends('layouts.template')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <a class="btn btn-primary" href="{{ route('admin.rooms.create') }}">Add Room</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Room Type</th>
                    <th scope="col">Price</th>
                    <th scope="col">Available</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rooms as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#paymentReceiptModal-{{ $loop->iteration }}">
                                View
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="paymentReceiptModal-{{ $loop->iteration }}" tabindex="-1"
                                role="dialog" aria-labelledby="paymentReceiptModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentReceiptModalLabel">Payment Receipt</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ Storage::url($item->image) }}" class="card-img-top"
                                                alt="room-image">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->roomType->name }}</td>
                        <td>{{ $item->roomType->daily_price }}</td>
                        <td>{!! $item->is_available == 0
                            ? '<button class="btn btn-success">Yes</button>'
                            : '<button class="btn btn-danger">No</button>' !!}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('admin.rooms.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.rooms.delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
