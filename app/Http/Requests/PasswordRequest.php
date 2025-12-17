<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordRequest extends FormRequest
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
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed', 'min:8', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Senha atual deve ser preenchida',
            'current_password.current_password' => 'Senha atual inválida',
            'password.required' => 'Senha deve ser preenchida',
            'password.confirmed' => 'As senhas devem ser iguais',
            'password.min' => 'Senha deve ter pelo menos 8 caracteres',
            'password.max' => 'Senha deve ter no máximo 255 caracteres',
        ];
    }
}
