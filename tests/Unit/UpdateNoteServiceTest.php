<?php

namespace Tests\Unit;

use App\Domains\Notes\Note;
use App\Domains\Notes\Services\FindNoteByIdService;
use App\Domains\Notes\Services\UpdateNoteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateNoteServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws \App\Support\Validation\ValidationException
     */
    public function test_update_a_note_by_id()
    {
        factory(Note::class)->create();

        $note = (new FindNoteByIdService(1))->handle();

        $title = 'New note title';
        $text = 'New note text';

        $newNote = (new UpdateNoteService($note->id, compact('title', 'text')))->handle();

        $this->assertNotEquals($newNote->title, $note->title);
        $this->assertNotEquals($newNote->text, $note->text);
        $this->assertEquals($note->id, $newNote->id);
    }
}
