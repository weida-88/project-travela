{{-- Menggunakan layouts admin --}}
@extends('layouts.template')

{{-- Section untuk menaruh content ke layout --}}
@section('content')
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">User</th>
                <th scope="col">Room</th>
                <th scope="col">Payment</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Rejected Reason</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->room->name }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#paymentReceiptModal-{{ $loop->iteration }}">
                            View
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="paymentReceiptModal-{{ $loop->iteration }}" tabindex="-1" role="dialog"
                            aria-labelledby="paymentReceiptModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentReceiptModalLabel">Payment Receipt</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ route('show.payment.receipt', basename($item->payment_receipt)) }}" alt="payment_receipt" class="w-100">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item->start_date }}</td>
                    <td>{{ $item->end_date }}</td>
                    <td>{{ number_format($item->amount) }}</td>
                    <td>
                        @if ($item->status == 'pending')
                            <button class="btn btn-warning">Pending</button>
                        @elseif ($item->status == 'approved')
                            <button class="btn btn-success">Approved</button>
                        @else
                            <button class="btn btn-danger">Rejected</button>
                        @endif
                    </td>
                    <td>{{ $item->rejected_reason }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
