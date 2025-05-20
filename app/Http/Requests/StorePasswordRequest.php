<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StorePasswordRequest extends FormRequest
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
            'password' => ['required', 'string', 'max:255', Password::min(8)->letters()->numbers()->symbols()->mixedCase()->uncompromised()],
            'url' => ['nullable', 'url', 'max:255', 'unique:passwords'],
            'username' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }
}
