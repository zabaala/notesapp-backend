<?php

namespace App\Domains\Notes\Services;

use App\Domains\Notes\Note;
use App\Domains\Notes\Validations\CreateNewNoteValidation;
use App\Support\Services\ServiceInterface;
use App\Support\Validation\ValidationException;

class CreateNoteService implements ServiceInterface
{
    /**
     * @var string
     */
    private $data;

    /**
     * CreateNoteService constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }

    /**
     * @param $data
     * @return CreateNoteService
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Handle the service.
     *
     * @return mixed
     * @throws ValidationException
     */
    public function handle()
    {
        (new CreateNewNoteValidation($this->data))->validate();

        $note = new Note();
        $note->title = $this->data['title'];
        $note->text = $this->data['text'] ?? null;
        $note->save();

        return $note;
    }


}
