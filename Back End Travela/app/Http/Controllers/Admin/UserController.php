<?php

namespace App\Http\Controllers\Admin;

// Methods
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Exception;

// Models
use App\Models\User;

class UserController extends Controller
{
    // Function untuk halaman utama dari user
    public function index()
    {
        // Variabel untuk menampung data user yang memiliki role user
        $user = User::where('role_id', 2)->get();
        // Variabel untuk data yang ada di view
        $viewData = [
            'title' => "User",
            // Variabel user diberikan untuk halaman disini
            'users' => $user,
        ];
        // Mengembalikan view user.user.index dengan data yang ada di variabel viewData
        return view('admin.users.index', $viewData);
    }

    public function create()
    {
        $viewData = [
            'title' => "Create User",
        ];
        return view('admin.users.create', $viewData);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role_id' => 'required',
            ]);
            Hash::make($validatedData['password']);
            User::create($validatedData);
            return redirect()->route('admin.user.index')->with('success', 'User created successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to create user!' . $e);
        }
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $viewData = [
            'title' => "Edit User",
            'user' => $user,
        ];
        return view('admin.users.edit', $viewData);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'role_id' => 'required',
            ]);
            if($validatedData['password'] != null) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }
            $user->update($validatedData);
            return redirect()->route('admin.user.index')->with('success', 'User updated successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to update user!' . $e);
        }
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        try {
            $user->delete();
            return redirect()->route('admin.user.index')->with('success', 'User deleted successfully!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to delete user!' . $e);
        }
    }
}