<?php

namespace App\Support\Validation\Test;

use \App\Support\Validation\Validator;

class SampleValidation extends Validator
{
    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3'
        ];
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'first_name.required' => '[custom]: The first name field is required.',
            'last_name.required' => '[custom]: The last name field is required.',
        ];
    }
}
