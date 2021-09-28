<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        $emailValidation = auth()->user() ? ['required', 'email'] : ['required', 'email', 'unique:users'];

        return [
            'email' => $emailValidation,
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'name_on_card' => ['required']
        ];
    }
}
