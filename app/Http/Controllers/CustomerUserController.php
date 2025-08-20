<?php

namespace App\Http\Controllers;

use App\Models\CustomerUser;
use Illuminate\Http\Request;

class CustomerUserController extends Controller
{
    // Show list of users
    public function index()
    {
        $users = CustomerUser::all();
        return view('customer_user.index', compact('users'));
    }

    // Show edit form
    public function edit($id)
    {
        $user = CustomerUser::findOrFail($id);
        return view('customer_user.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = CustomerUser::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:customer_users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Other',
        ]);

        $user->update($validated);

        return redirect()->route('customer_user.index')
                         ->with('success', 'User updated successfully.');
    }
}
