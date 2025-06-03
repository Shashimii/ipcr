<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // User Roles
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    public function isAdmin() 
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Relationships
    public function assignedDuty() {
        return $this->hasMany(AssignedDuty::class, 'officer_id');
    }

    // Search Query
    public function scopeSearch(Builder $query, Request $request)
    {
        return $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                    ->orwhere('email', 'like', '%' . $request->search . '%');
        });
    }

    // Defaults
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
