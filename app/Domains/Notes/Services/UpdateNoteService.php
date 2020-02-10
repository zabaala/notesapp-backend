<?php

namespace App\Domains\Notes\Services;

use App\Domains\Notes\Note;
use App\Domains\Notes\Validations\UpdateNoteValidation;
use App\Support\Services\ServiceInterface;
use App\Support\Validation\ValidationException;

class UpdateNoteService implements ServiceInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $id;

    /**
     * UpdateNoteService constructor.
     * @param $id
     * @param array $data
     */
    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    public function handle()
    {
        $data = $this->data;
        $data['id'] = $this->id;

        (new UpdateNoteValidation($data))->validate();

        $note = Note::findOrFail($this->id);
        $note->title = $this->data['title'];
        $note->text = $this->data['text'];
        $note->save();

        return $note;
    }
}
