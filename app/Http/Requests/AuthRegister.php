<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegister extends FormRequest
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
            'name' =>'alpha_dash|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages['email'] = 'not valid email';
        $messages['password'] = 'password is required';
        
        return $messages;
    }
}
