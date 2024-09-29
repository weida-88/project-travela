<?php
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $viewData = [
            'title' => "Booking",
            'bookings' => $bookings,
        ];

        return view('user.bookings.index', $viewData);
    }
    public function book(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'room_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'amount' => 'required',
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

        try {
            $paymentReceiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                // Simpan file gambar ke dalam folder 'payment_receipts' di 'storage/app/private
                $file = $request->file('payment_receipt');
                $paymentReceiptPath = Storage::disk('private')->put('payment_receipts', $file);
                $validatedData['payment_receipt'] = $paymentReceiptPath;
            }

            Booking::create($validatedData);

            return redirect()->route('user.dashboard')->with('success', 'Booking has been successfully created.');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the booking. Please try again.');
        }
    }
}
