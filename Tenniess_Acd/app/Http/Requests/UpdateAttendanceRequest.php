<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'player_id'=>'sometimes|required|exists:players,id',
            'coache_id'=>'sometimes|required|exists:coaches,id',
            'date'=>'sometimes|required|date',
            'status' => 'sometimes|required|in:present,absent,late,excused'
        ];
    }
}
