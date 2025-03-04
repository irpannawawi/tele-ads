<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdministratorController extends Controller
{

public function index()
{
    $users = User::all();
    return view('dash.administrator.index', compact('users'));
}

public function create()
{
    return view('dash.administrator.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    return redirect()->route('dash.administrator.index')->with('success', 'User created successfully.');
}

public function show(User $user)
{
    return view('dash.administrator.show', compact('user'));
}

public function edit($id)
{
    $user = User::find($id);
    return view('dash.administrator.edit', compact('user'));
}

public function update(Request $request,  $id)
{
    $user = User::find($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|confirmed',
    ]);

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
    ]);
    return redirect()->route('dashboard.administrator')->with('success', 'User updated successfully.');
}

public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('dashboard.administrator')->with('success', 'User deleted successfully.');
}

}
