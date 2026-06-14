<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscibitionRequest extends FormRequest
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
            'player_id' => 'sometimes|required|exists:players,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'plan_id' => 'sometimes|required|exists:plans,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'status' => 'sometimes|required|in:pending,active,canceled,expired,frozen,approved,rejected',
            'payment_status' => 'sometimes|required|in:pending,paid,failed',
        ];
    }
}
