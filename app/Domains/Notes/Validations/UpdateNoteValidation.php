<?php

namespace App\Domains\Notes\Validations;

use App\Support\Validation\Validator;

class UpdateNoteValidation extends Validator
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:notes,id',
            'title' => 'required|min:3'
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [
            'id.exists' => "Note {$this->id} doesn't exists."
        ];
    }
}
