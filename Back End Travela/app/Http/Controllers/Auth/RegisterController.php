<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Exception;

// Import Models
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Register',
        ];

        return view('auth.register', $viewData);
    }

    public function register(Request $request)
    {
        // Validate the form data
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role_id' => 'required',
            ]);
            // Hash the password
            Hash::make($validatedData['password']);

            // Register the user
            $user = User::create($validatedData);

            // Sign the user in
            auth()->login($user);

            // Redirect to the home page
            return redirect()->route('user.dashboard')->with('success', 'Welcome to TRAVELA BOOK!');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Failed to register your Account!' . $e);
        }
    }
}
