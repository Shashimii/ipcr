<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignedDutyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'officer_id' => 'required|exists:officers,id',
            'duty_id' => 'required|exists:duties,id',
            'odts_code' => 'required|string|max:255',
            'assigned_at' => 'required|date',
            'is_done' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'officer_id' => 'Officer',
            'duty_id' => 'Duty',
            'odts_code' => 'Odts Code',
            'assigned_at' => 'Date',
        ];
    }
}
