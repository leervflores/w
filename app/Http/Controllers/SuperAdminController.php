<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CustomerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->orderBy('id', 'desc')->get();
        $customer_users = CustomerUser::orderBy('id', 'desc')->get();

        return view('super_admin.superAdmin', compact('users', 'customer_users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|string'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'User added successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|string'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('superadmin.dashboard')->with('error', 'Cannot delete own account.');
        }
        User::destroy($id);
        return redirect()->route('superadmin.dashboard')->with('success', 'User deleted successfully.');
    }

    // CustomerUser CRUD
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customer_users,email'
        ]);

        CustomerUser::create($request->only('name', 'email'));
        return redirect()->route('superadmin.dashboard')->with('success', 'Customer added successfully.');
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = CustomerUser::findOrFail($id);
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customer_users,email,' . $customer->id
        ]);

        $customer->update($request->only('name', 'email'));
        return redirect()->route('superadmin.dashboard')->with('success', 'Customer updated successfully.');
    }

    public function destroyCustomer($id)
    {
        CustomerUser::destroy($id);
        return redirect()->route('superadmin.dashboard')->with('success', 'Customer deleted successfully.');
    }
}
