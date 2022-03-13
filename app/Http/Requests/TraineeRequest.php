<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TraineeRequest extends FormRequest
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
                    'image' => 'required|image|max:1024',
                    'enrollment_no' => 'required|max:255|unique:trainees',
                    'full_name' => 'required|string|min:4',
                    'name_with_initials' => 'required|string|min:4',
                    'gender' => 'required',
                    'ethnicity' => 'required',
                    'course_id' => 'required',
                    'batch_id' => 'required',
                    'nic' => 'required|regex:/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/m]',
                    'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                    'address' => 'required|min:4',
                    'city' => 'required|string',
                    'email' => 'nullable|unique:trainees',
                    'qualification' => 'required|min:4',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'image' => 'image|max:1024',
                    'enrollment_no' => [
                        'required',
                        'max:255',
                        Rule::unique('trainees', 'enrollment_no')->ignore($this->trainee)
                    ],
                    'full_name' => 'required|string|min:4',
                    'name_with_initials' => 'required|string|min:4',
                    'gender' => 'required',
                    'ethnicity' => 'required',
                    'course_id' => 'required',
                    'batch_id' => 'required',
                    'nic' => 'required',
                    'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
                    'address' => 'required|min:4',
                    'city' => 'required|string',
                    'email' => [
                        'required',
                        Rule::unique('trainees', 'email')->ignore($this->trainee)
                    ],
                    'qualification' => 'required|min:4',
                ];
            }
            default:break;
        }
    }
}
