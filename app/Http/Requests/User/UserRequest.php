<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $routeName = $this->route()->getName();
        return match ($routeName) {
          'auth.user-data.update' => $this->userUpdateRequest(),
            default => $this->userStoreRequest(),
        };

    }
    private function userStoreRequest(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|integer|exists:roles,id',
        ];
    }
    private function userUpdateRequest(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array|min:1',
            'roles.*' => 'nullable|integer|exists:roles,id',
        ];
    }
}
