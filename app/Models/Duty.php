<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Relationships    
    public function assignedDuty() {
        return $this->hasMany(AssignedDuty::class, 'duty_id');
    }
}
