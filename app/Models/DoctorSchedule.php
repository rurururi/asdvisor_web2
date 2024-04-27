<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'start_time',
        'end_time',
        'weekdays'
    ];

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointment() {
        return $this->hasMany(Appointment::class);
    }
}
