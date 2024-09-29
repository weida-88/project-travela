{{-- Menggunakan layouts admin --}}
@extends('layouts.template')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
    <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"required>
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="transfer_receipt">Image</label>
            <input type="file" name="image" class="form-control mb-2" required>
            @error('image')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="roomType" class="form-label">Room Type</label>
            <select name="room_type_id" id="roomTypeId" class="form-select">
                <option value="">Pilih Tipe Kamar</option>
                @foreach ($roomTypes as $roomType)
                    <option value="{{ $roomType->id }}">{{ $roomType->name }} ({{ $roomType->daily_price }})</option>
                @endforeach
            </select>
            @error('room_type_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <input type="hidden" name="is_available" value="0">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
