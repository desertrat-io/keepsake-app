<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends KeepsakeFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function getUsefulKeys(): Collection
    {
        return collect($this->rules())->reduce(fn (string $rule) => $rule != 'password_confirm');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'email' => ['email', 'required', 'unique:users'],
            'password' => [
                'string',
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
            ],
            'password_confirm' => ['required', 'string']
        ];
    }

}
