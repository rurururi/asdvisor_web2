<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'appointment_id',
        'doctor_id',
        'image',
        'ref_no',
        'amount'
    ];

    public function parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
