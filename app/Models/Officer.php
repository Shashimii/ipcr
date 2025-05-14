<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Relationships
    public function assignedDuty() {
        return $this->hasMany(AssignedDuty::class, 'officer_id');
    }
}
