<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Officer extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Relationships
    public function assignedDuty() {
        return $this->hasMany(AssignedDuty::class, 'officer_id');
    }

    
    public function scopeSearch(Builder $query, Request $request)
    {
        return $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        });
    }
}
