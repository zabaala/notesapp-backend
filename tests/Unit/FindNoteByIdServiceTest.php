<?php

namespace Tests\Unit;

use App\Domains\Notes\Note;
use App\Domains\Notes\Services\FindNoteByIdService;
use App\Support\Popo\PlainOldPhpObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindNoteByIdServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $note;
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $title;

    public function setUp(): void
    {
        parent::setUp();

        $this->title = 'A sample title...';
        $this->text = 'A sample text';

        $this->note = factory(Note::class)->create([
            'title' => $this->title,
            'text' => $this->text,
        ]);
    }

    public function test_find_a_note_with_a_invalid_id()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        (new FindNoteByIdService(2))->handle();
    }

    public function test_find_a_existing_note_by_id()
    {
        $note = (new FindNoteByIdService(1))->handle();

        $this->assertInstanceOf(PlainOldPhpObject::class, $note);
        $this->assertEquals($note->id, $this->note->id);
        $this->assertEquals($note->title, $this->note->title);
        $this->assertEquals($note->text, $this->note->text);
    }
}
