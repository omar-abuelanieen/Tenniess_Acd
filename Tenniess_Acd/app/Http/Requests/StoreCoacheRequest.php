<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidCoachCapacityRule;
class StoreCoacheRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'user_id'=>'required|exists:users,id',
            'role_id'=>'required|exists:roles,id',
            'expertise'=>'required|string|max:255',
            'player_count'=>['required', 'integer', new ValidCoachCapacityRule()],
        ];
    }
}
