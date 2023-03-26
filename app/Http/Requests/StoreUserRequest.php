<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Fortify\PasswordValidationRules;
// use Laravel\Jetstream\Jetstream;

class StoreUserRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'size:9', 'unique:users'],
            'password' => $this->passwordRules(),
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];
    }
}
