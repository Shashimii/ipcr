<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

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

    // search query

    public function scopeSearch(Builder $query, Request $request)
    {
        return $query->when($request->search, function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query
                    ->where('odts_code', 'like', '%' . $request->search . '%') // Odts Code
                    ->orWhere('assigned_at', 'like', '%' . $request->search . '%') // Assigned at
                    
                    ->orWhereHas('officer', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%'); // Officer's Name
                    })

                    ->orWhereHas('duty', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%'); // Duty's Name
                    });
            });
        })
        
        ->when($request->officer_id, function ($query) use ($request) {
            $query->where('officer_id', $request->officer_id);
        });
    }

}
