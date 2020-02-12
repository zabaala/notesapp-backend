<?php

namespace Tests\Unit;

use App\Domains\Notes\Note;
use App\Domains\Notes\Services\FindNoteByIdService;
use App\Support\Popo\PlainOldPhpObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PopoTest extends TestCase
{
    use RefreshDatabase;

    public function test_parse()
    {
        $data = [
            'title' => 'title of note.',
            'text' => 'text of note.',
            'created_at' => '2020-08-08 21:40:00',
            'updated_at' => '2020-08-09 21:45:00'
        ];

        factory(Note::class)->create($data);

        $id = 1;

        $note = (new FindNoteByIdService($id))->handle();

        // check instance...
        $this->assertInstanceOf(PlainOldPhpObject::class, $note);

        // checks for attributes...
        $this->assertEquals($note->has('id'), true);
        $this->assertEquals($note->has('title'), true);
        $this->assertEquals($note->has('text'), true);
        $this->assertEquals($note->has('created_at'), true);
        $this->assertEquals($note->has('updated_at'), true);
        $this->assertEquals($note->has('password'), false);
        $this->assertEquals($note->has('id'), true);

        // check values...
        $this->assertEquals($id, $note->id);
        $this->assertEquals($data['title'], $note->title);
        $this->assertEquals($data['text'], $note->text);
        $this->assertEquals($data['created_at'], $note->created_at);
        $this->assertEquals($data['updated_at'], $note->updated_at);

        // check number of present attributes...
        $this->assertEquals(count($data) + 1, count($note->all()));
    }
}
