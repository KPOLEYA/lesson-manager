<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'phone' => 'max:15',
            'email' => 'nullable|email',
            'level' => 'required|numeric|exists:levels,id',
            'class_option' => 'nullable|string|max:255',
            'add_parents' => 'boolean',
            'name_parents' => 'string|max:255|required_if:add_parents,true',
            'firstname_parents' => 'string|max:255',
            'email_parents' => 'email|required_if:add_parents,true',
            'phone_parents' => 'max:15',
        ];
    }
}
