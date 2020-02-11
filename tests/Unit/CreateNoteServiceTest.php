<?php

namespace Tests\Unit;

use \App\Domains\Notes\Note;
use App\Domains\Notes\Services\CreateNoteService;
use App\Support\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CreateNoteServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_count_records_in_database()
    {
        $this->expectException(\App\Support\Validation\ValidationException::class);
        (new CreateNoteService([]))->handle();
    }

    public function test_validation_response()
    {
        $service = new CreateNoteService([]);

        try {
            $service->handle();
        } catch (ValidationException $e) {
            $this->assertEquals(1, count($e->get('title')));
        }
    }

    /**
     * @throws ValidationException
     */
    public function test_new_note_creation_only_with_title()
    {
        $title = 'Foo bar baz...';

        $note = (new CreateNoteService([
            'title' => $title,
        ]))->handle();

        $this->assertEquals(1, $note->id);
        $this->assertEquals($title, $note->title);
        $this->assertEquals(null, $note->text);
    }

    /**
     * @throws ValidationException
     */
    public function test_new_note_creation_only_with_title_and_text()
    {
        $title = 'A new note example...';
        $text = 'A sample text...';

        $note = (new CreateNoteService([
            'title' => $title,
            'text' => $text
        ]))->handle();

        $this->assertEquals(1, $note->id);
        $this->assertEquals($title, $note->title);
        $this->assertEquals($text, $note->text);
    }
}
