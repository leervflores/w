<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BusDriver extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'fullname', 'address', 'dob', 'email', 'phone',
        'conductor_id', 'password', 'license_number', 'document_path', 'status'
    ];

    protected $hidden = ['password'];

    public function verificationLogs()
    {
        return $this->hasMany(DriverVerificationLog::class, 'driver_id');
    }
}
