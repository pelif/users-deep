<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class NewPasswordRequest extends FormRequest
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
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'O token é requerido',
            'email.required' => 'E-mail deve ser preenchido',
            'email.email' => 'E-mail inválido',
            'password.required' => 'Senha deve ser preenchida',
            'password.confirmed' => 'As senhas devem ser iguais',
            'password.min' => 'Senha deve ter pelo menos 8 caracteres',
            'password.max' => 'Senha deve ter no máximo 255 caracteres',
        ];
    }
}
