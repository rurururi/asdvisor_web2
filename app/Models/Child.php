<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'childs';
    protected $fillable = [
        'parent_id',
        'doctor_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
    ];

    public function parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function child_stats_history()
    {
        return $this->hasMany(ChildStatsHistory::class);
    }

    public function child_information_history()
    {
        return $this->hasMany(ChildInformationHistory::class);
    }
}
