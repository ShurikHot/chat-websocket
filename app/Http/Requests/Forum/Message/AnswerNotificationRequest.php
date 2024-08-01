<?php

namespace App\Http\Requests\Forum\Message;

use Illuminate\Foundation\Http\FormRequest;

class AnswerNotificationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'theme_id' => 'required|integer|exists:themes,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
