<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load('role');
        return view('profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'current_password' => 'required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Huidig wachtwoord is onjuist']);
            }
        }

        if ($request->filled('password') && !$request->filled('current_password')) {
            return back()->withErrors(['current_password' => 'Huidig wachtwoord is verplicht om nieuw wachtwoord in te stellen']);
        }

        // Restrict non-admin users to only update avatar and password
        if ($user->role->name !== 'admin') {
            // Only allow avatar and password updates for non-admins
            $allowedFields = ['avatar', 'password', 'current_password'];
            
            // Check if user is trying to modify restricted fields
            if ($request->filled('name') && $request->name !== $user->name) {
                return back()->withErrors(['name' => 'You are not allowed to change your name']);
            }
            
            if ($request->filled('email') && $request->email !== $user->email) {
                return back()->withErrors(['email' => 'You are not allowed to change your email']);
            }
            
            if ($request->filled('phone') && $request->phone !== $user->phone) {
                return back()->withErrors(['phone' => 'You are not allowed to change your phone number']);
            }
        }

        // Avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                $path = str_replace('storage/', '', $user->avatar);
                Storage::disk('public')->delete($path);
            }

            // Slaat op in storage/app/public/media/avatars
            $path = $request->file('avatar')->store('media/avatars', 'public');
            $user->avatar = $path;
        }

        // Update basic info (only for admins)
        if ($user->role->name === 'admin') {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
        }

        $user->save();

        return redirect()->route('profile.view')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        // Verify password for security
        if (!Hash::check($request->input('password', ''), $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password']);
        }
        
        // Logout the user
        Auth::logout();
        
        // Delete the user
        $user->delete();
        
        // Redirect to home with success message
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}