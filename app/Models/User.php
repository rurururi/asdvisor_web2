<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

// Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_level',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function child()
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function doctor_schedule()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    public function daily_care()
    {
        return $this->hasMany(DailyCare::class, 'doctor_id');
    }
    
    public function child_information_history()
    {
        return $this->hasMany(ChildInformationHistory::class, 'doctor_id');
    }

    public function child_stats_history()
    {
        return $this->hasMany(ChildStatsHistory::class, 'doctor_id');
    }

    public function doctor_question()
    {
        return $this->hasMany(DoctorQuestion::class, 'doctor_id');
    }

    public function doctor_answer()
    {
        return $this->hasMany(DoctorAnswer::class, 'doctor_id');
    }

    public function care_decision()
    {
        return $this->hasMany(CareDecision::class, 'parent_id');
    }
}
