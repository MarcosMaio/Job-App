<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:5',
            'feature_image' => 'required|mimes:jpg,jpeg,png|image|max:2048',
            'description' => 'required|min:10',
            'roles' => 'required|min:10',
            'job_type' => 'required',
            'address' => 'required',
            'salary' => 'required',
            'application_close_date' => 'required',
        ];
    }
}
