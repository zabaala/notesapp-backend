<?php

namespace App\Domains\Notes\Validations;

use App\Support\Validation\Validator;

class CreateNewNoteValidation extends Validator
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [];
    }
}
