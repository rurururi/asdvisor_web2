<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildInformationHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'parent_id',
        'child_id',
        'behavior',
        'assessment'
    ];

    public function child() {
        return $this->belongsTo(Child::class, 'child_id');
    }
    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
