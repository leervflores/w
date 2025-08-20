<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusDriver;
use App\Models\DriverVerificationLog;

class DriverVerificationController extends Controller
{
    public function pending()
    {
        $drivers = BusDriver::where('status', 'pending')->get();
        return view('admin.drivers.pending', compact('drivers'));
    }

    public function approve($id)
    {
        $driver = BusDriver::findOrFail($id);
        $driver->status = 'approved';
        $driver->save();

        DriverVerificationLog::create([
            'driver_id' => $driver->id,
            'admin_id' => auth()->id(),
            'action' => 'approved',
            'timestamp' => now(),
        ]);

        return redirect()->route('drivers.pending')->with('success', 'Driver approved.');
    }

    public function reject($id)
    {
        $driver = BusDriver::findOrFail($id);
        $driver->status = 'rejected';
        $driver->save();

        DriverVerificationLog::create([
            'driver_id' => $driver->id,
            'admin_id' => auth()->id(),
            'action' => 'rejected',
            'timestamp' => now(),
        ]);

        return redirect()->route('drivers.pending')->with('success', 'Driver rejected.');
    }

    public function requestChanges(Request $request, $id)
    {
        $driver = BusDriver::findOrFail($id);
        $driver->status = 'changes_requested';
        $driver->save();

        DriverVerificationLog::create([
            'driver_id' => $driver->id,
            'admin_id' => auth()->id(),
            'action' => 'changes_requested',
            'remarks' => $request->remarks,
            'timestamp' => now(),
        ]);

        return redirect()->route('drivers.pending')->with('success', 'Change request sent.');
    }
}
