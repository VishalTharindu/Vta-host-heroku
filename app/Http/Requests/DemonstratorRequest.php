<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemonstratorRequest extends FormRequest
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
                    'nic' => 'required',
                    'first_name' => 'required|string|min:3|max:255',
                    'last_name' => 'required|string|min:3|max:255',
                    'email' => 'required|email',
                    'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                    'address' => 'required|string',
                    'city' => 'required|string',
                    'login-email' => 'required|unique:users,email',
                    'login-password' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'nic' => 'required',
                    'first_name' => 'required|string|min:3|max:255',
                    'last_name' => 'required|string|min:3|max:255',
                    'email' => 'required|email',
                    'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                    'address' => 'required|string',
                    'city' => 'required|string',
                ];
            }
            default:break;
        }

    }
}
