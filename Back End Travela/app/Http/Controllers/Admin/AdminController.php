<?php

namespace App\Http\Controllers\Admin;

//  Method
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Exception;

// Models
use App\Models\User;

class AdminController extends Controller
{
    // Function untuk halaman utama dari admin
    public function index()
    {
        // Variabel untuk menampung data user yang memiliki role admin
        $admin = User::where('role_id', 1)->get();
        // Variabel untuk data yang ada di view
        $viewData = [
            'title' => "Admin",
            // Variabel admin diberikan untuk halaman disini
            'admin' => $admin,
        ];
        // Mengembalikan view admin.admin.index dengan data yang ada di variabel viewData
        return view('admin.admin.index', $viewData);
    }

    public function create()
    {
        $viewData = [
            'title' => "Create Admin",
        ];
        return view('admin.admin.create', $viewData);
    }

    public function store(Request $request)
    {
        try {
            // Validasi data request
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,id', // Pastikan role_id ada di tabel roles
            ]);

            // Hash password
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Buat user baru
            User::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('admin.admin.index')->with('success', 'User created successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            // Tangani error umum lainnya
            return back()->withInput()->with('error', 'Failed to create user! ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $admin = User::find($id);
        $viewData = [
            'title' => "Edit Admin",
            'activePage' => "user",
            'admin' => $admin,
        ];
        return view('admin.admin.edit', $viewData);
    }

    public function update(Request $request, string $id)
    {
        $admin = User::find($id);
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'role_id' => 'required',
            ]);

            if ($validatedData['password'] != null) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }
            
            $admin->update($validatedData);
            return redirect()->route('admin.admin.index')->with('success', 'User updated successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to update user!' . $e);
        }
    }

    public function destroy(Request $request)
    {
        $admin = User::find($request->id);
        try {
            $admin->delete();
            return redirect()->route('admin.admin.index')->with('success', 'User deleted successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to delete user!' . $e);
        }
    }
}