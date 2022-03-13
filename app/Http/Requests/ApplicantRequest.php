<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicantRequest extends FormRequest
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
            'full_name' => 'required|string|min:4',
            'name_with_initials' => 'required|string|min:4',
            'nic' => [
                'required',
                'regex:/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/m',
                Rule::unique('applicants', 'nic')->ignore($this->applicant)
            ],
            'email' => [
                'email:filter',
                Rule::unique('applicants', 'email')->ignore($this->applicant)
            ],
            'gender' => 'required',
            'ethnicity' => 'required',
            'phone_number' => 'required|numeric|regex:/[0-9]{10}/',
            'address' => 'required',
            'city' => 'required',
            'qualification' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nic.unique' => 'Same NIC number contain in another applicant',
        ];
    }
}