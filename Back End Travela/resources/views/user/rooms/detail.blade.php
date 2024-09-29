@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <img src="{{ Storage::url($room->image) }}" alt="room_image" class="w-100">
            </div>
            <div class="col-6">
                <h1>{{ $room->name }}</h1>
                <h3 class="text-secondary">{{ $room->roomType->name }}</h3>
                <h4>IDR {{ number_format($room->roomType->daily_price) }}</h4>
                <p>{{ $room->description }}</p>
                @if ($room->is_available == 0)
                    <form action="{{ route('user.book') }}" method="POST" class="d-flex flex-column gap-2" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        @error('user_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        @error('room_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="hidden" name="status" value="pending">
                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="hidden" id="dailyPrice" value="{{ $room->roomType->daily_price }}">

                        <label for="start_date">Check In</label>
                        <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                        @error('start_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label for="end_date">Check Out</label>
                        <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                        @error('end_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control mb-2" id="amount" required readonly>
                        @error('amount')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label for="payment_receipt">Payment Receipt</label>
                        <input type="file" name="payment_receipt" class="form-control mb-2" required>
                        @error('payment_receipt')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="btn btn-primary">Book Now!</button>
                    </form>
                @else
                    <button class="btn btn-danger w-100">This room has been booked</button>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-success w-100 mt-2">Back</a>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts') 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const amountInput = document.getElementById('amount');
            const dailyPrice = document.getElementById('dailyPrice').value;

            function calculateAmount() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (!isNaN(startDate) && !isNaN(endDate) && startDate < endDate) {
                    const timeDifference = endDate - startDate;
                    const daysDifference = timeDifference / (1000 * 3600 * 24);
                    const totalAmount = daysDifference * dailyPrice;
                    amountInput.value = totalAmount;
                } else {
                    amountInput.value = 0;
                }
            }

            startDateInput.addEventListener('change', calculateAmount);
            endDateInput.addEventListener('change', calculateAmount);
        });
    </script>
@endpush
