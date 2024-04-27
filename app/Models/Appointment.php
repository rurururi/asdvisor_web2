<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'parent_id',
        'doctor_schedule_id',
        'appointment_date',
        'appointment_end_date',
    ];

    public function parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function doctor_schedule() {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }
}