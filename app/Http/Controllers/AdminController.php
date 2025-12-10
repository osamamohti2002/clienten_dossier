<?php

namespace App\Http\Controllers;
use \App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::all();
        return view('admin.manage-users', compact('users'));
    }

    public function userCount(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::with('role')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->limit(5)
            ->get();
        
        $totalUsers = User::count();
        
        return view('admin.index', compact('totalUsers', 'users', 'search'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
