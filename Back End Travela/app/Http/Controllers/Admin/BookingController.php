<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

// Import Models
use App\Models\Booking;
use App\Models\Room;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        $viewData = [
            'title' => "Booking",
            'bookings' => $bookings,
        ];

        return view('admin.bookings.index', $viewData);
    }

    public function approve(Request $request)
    {
        try {
            $booking = Booking::find($request->id);
            $room = Room::find($booking->room_id);
            $booking->update(
                [
                    'status' => 'approved',
                ]
            );
            
            $room->update(
                [
                    'is_available' => 1,
                ]
            );
            return back()->with('success', 'Booking has been successfully approved.');
        } catch (Exception $e) {
            dd($e);
            return back()->with('error', 'An error occurred while approving the booking. Please try again.');
        }
    }

    public function reject(Request $request)
    {
        try {
            $booking = Booking::find($request->id);
            $room = Room::find($booking->room_id);
            $booking->update(
                [
                    'status' => 'rejected',
                    'rejected_reason' => $request->rejected_reason,
                ]
            );
            return back()->with('success', 'Booking has been successfully rejected.');
        } catch (Exception $e) {
            return back()->with('error', 'An error occurred while rejecting the booking. Please try again.');
        }
    }
}
