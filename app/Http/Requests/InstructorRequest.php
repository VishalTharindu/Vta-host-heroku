<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'first_name' => 'required|string|min:4',
                    'last_name' => 'required|string|min:4',
                    'nic' => 'required|string|min:4',
                    'email' => 'required|email',
                    'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                    'city' => 'required|string',
                    'address' => 'required|string',
                    'login-email' => 'required|unique:users,email',
                    'login-password' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'first_name' => 'required|string|min:4',
                    'last_name' => 'required|string|min:4',
                    'nic' => 'required|string|min:4',
                    'email' => 'required|email',
                    'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                    'city' => 'required|string',
                    'address' => 'required|string',
                ];
            }
            default:break;
        }
        
        
        
    }
}
