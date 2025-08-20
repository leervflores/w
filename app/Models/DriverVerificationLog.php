<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVerificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 'admin_id', 'action', 'remarks', 'timestamp'
    ];
}
