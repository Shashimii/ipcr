<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignedDuty extends Model
{
    use HasFactory;
    protected $fillable = ['officer_id', 'duty_id', 'odts_code', 'assigned_at', 'is_done'];
    protected $casts = [
        'assigned_at' => 'date:Y-m-d',  // Format the assigned_at column as a date
        'is_done' => 'boolean',         // Format is_done as a boolean
    ];

    // whenLoaded eager loading is declared like this
    protected $with = ['officer', 'duty'];

    // Relationships
    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }

    public function duty()
    {
        return $this->belongsTo(Duty::class);
    }
}
