<?php

namespace App\Http\Controllers\Admin;

// Methods
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Exception;

// Models
use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    // Function untuk halaman utama dari Room
    public function index()
    {
        $rooms = Room::all();
        $viewData = [
            'title' => "Rooms Management",
            'rooms' => $rooms,
        ];
        return view('admin.rooms.index', $viewData);
    }

    public function create()
    {
        $viewData = [
            'title' => "Create Room",
            'roomTypes' => RoomType::all(),
        ];
        return view('admin.rooms.create', $viewData);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'room_type_id' => 'required',
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required',
                'is_available' => 'required',
            ]);
            if ($request->hasFile('image')) {
                // Simpan file gambar ke dalam folder 'images' di 'storage/app/private'
                $file = $request->file('image');
                $imagePath = Storage::disk('public')->put('room_images', $file);
                $validatedData['image'] = $imagePath;
            }
            Room::create($validatedData);
            return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to create Room' . $e);
        }
    }

    public function edit(string $id)
    {
        $room = Room::find($id);
        $viewData = [
            'title' => "Edit Room",
            'data' => $room,
            'roomTypes' => RoomType::all(),
        ];
        return view('admin.rooms.edit', $viewData);
    }

    public function update(Request $request, string $id)
    {
        $room = Room::find($id);
        try {
            $validatedData = $request->validate([
                'room_type_id' => 'required',
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required',
            ]);
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($room->image && Storage::disk('public')->exists($room->image)) {
                    Storage::disk('public')->delete($room->image);
                }
                // Simpan file gambar baru ke dalam folder 'room_images' di 'storage/app/private'
                $file = $request->file('image');
                $imagePath = Storage::disk('public')->put('room_images', $file);
                $validatedData['image'] = $imagePath;
            }
            $room->update($validatedData);
            return redirect()->route('admin.rooms.index')->with('success', 'Room edited successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to edit Room!' . $e);
        }
    }

    public function destroy(Request $request)
    {
        $room = Room::find($request->id);
        try {
            $room->delete();
            return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to delete Room!' . $e);
        }
    }
}