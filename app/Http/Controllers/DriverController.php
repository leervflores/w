<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusDriver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function create()
    {
        return view('driver.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'email' => 'required|email|unique:bus_drivers,email',
            'phone' => 'required|string|max:20',
            'conductor_id' => 'required|string|unique:bus_drivers,conductor_id',
            'password' => 'required|string|min:6|confirmed',
            'license_number' => 'required|string|max:50',
            'document' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $path = $request->file('document')->store('driver_docs', 'public');

        BusDriver::create([
            'fullname' => $request->fullname,
            'address' => $request->address,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'conductor_id' => $request->conductor_id,
            'password' => Hash::make($request->password),
            'license_number' => $request->license_number,
            'document_path' => $path,
            'status' => 'pending'
        ]);

        return redirect()->route('driver.status')->with('success', 'Driver registration submitted for approval.');
    }

    public function status()
    {
        $driver = BusDriver::where('email', Auth::user()->email)->first();
        return view('driver.status', compact('driver'));
    }
}
