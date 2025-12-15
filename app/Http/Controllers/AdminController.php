<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');

        $users = User::with('role')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->limit(5)
            ->get();

        $totalUsers = User::count();

        return view('admin.dashboard', compact('users', 'totalUsers', 'search')); 
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
        public function create()
    {
        $roles = Role::all(); 
        return view('admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);



        
        // Create the user
        $user = User::create([
            'name' => $validated['naam'],
            'email' => $validated['email'],
            'phone' => $request->phone,
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'], 
        ]);

        // Redirect back with success message
        return redirect()->route('admin.create') // Changed from 'admin.test' to 'admin.create'
            ->with('success', 'Gebruiker succesvol aangemaakt!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|max:20',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Mederwerker bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')
        ->with('success', 'Medewerker verwijderen.');
    }
}
