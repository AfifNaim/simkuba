<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
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
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => [
                Rule::when(request()->isMethod('POST'), 'required'),
                Rule::when(request()->isMethod('PUT'), 'optional'),
                'min:8'
            ],
            'phone' => 'required|min:10',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->password)
            $this->merge(['password' => bcrypt($this->password)]);
    }
}
