<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignedDutyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // edit route
        if ($request->routeIs('assigned-duties.edit')) {
            return [
                'id' => $this->id,
                'officer' => OfficerResource::make($this->whenLoaded('officer')),
                'duty' => DutyResource::make($this->whenLoaded('duty')),
                'odts_code' => $this->odts_code,
                'is_done' => $this->is_done,
                'assigned_at' => $this->assigned_at->toDateString()
            ];
        } 

        // any route
        return [
            'id' => $this->id,
            'officer' => OfficerResource::make($this->whenLoaded('officer')),
            'duty' => DutyResource::make($this->whenLoaded('duty')),
            'odts_code' => $this->odts_code,
            'is_done' => $this->is_done,
            'assigned_at' => $this->assigned_at->format('m-d-Y')
        ];
    }
}
