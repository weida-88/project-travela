@extends('layouts.template')

@section('content')
    <div class="container text-center">
        <h2>
            Welcome to our hotel booking system
        </h2>
        <h4>Please choose your room</h4>
    </div>
    <div class="d-flex gap-4">
        @forelse ($rooms as $item)
            <div class="card" style="width: 18rem; height:500px;">
                <img src="{{ Storage::url($item->image) }}" class="card-img-top"
                    style="height: 200px; width: 100%; object-fit: cover;" alt="room-image">
                <div class="card-body d-flex flex-column gap-2 justify-content-between">
                    <div class="d-flex flex-column">
                        <h5 class="card-title">{{ $item->roomType->name }} | {{ $item->name }}</h5>
                        <p class="card-text">
                            {{ Str::limit($item->description, 200) }}
                        </p>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <h5>IDR {{ number_format($item->roomType->daily_price) }}</h5>
                        @if ($item->is_available == 0)
                            <div class="badge bg-success py-1"><h6>Available</h6></div>
                        @else
                            <div class="badge bg-danger py-1"><h6>Booked</h6></div>
                        @endif
                        <a href="{{ route('user.roomDetail', $item->id) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <h4 class="text-center">No Data</h4>
        @endforelse
    </div>
@endsection
