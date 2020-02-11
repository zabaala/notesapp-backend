<?php

namespace App\Domains\Notes\Services;

use App\Domains\Notes\Note;
use App\Support\Services\ServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FindNoteByIdService implements ServiceInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * FindNoteByIdService constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Handle the service.
     *
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function handle()
    {
        $note = Note::find($this->id);

        if (is_null($note)) {
            throw new ModelNotFoundException("Note with id {$this->id} not found.");
        }

        return $note;
    }
}
