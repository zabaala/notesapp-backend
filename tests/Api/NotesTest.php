<?php

namespace Tests\Api;

use App\Domains\Notes\Note;
use App\Support\Pagination\JsonStructure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotesTest extends TestCase
{
    use RefreshDatabase;

    const RECORDS = 10;

    public function setUp(): void
    {
        parent::setUp();
        factory(Note::class, self::RECORDS)->create();
    }

    public function test_index_resource()
    {
        $this->get(route('notes.index'))
            ->assertStatus(200)
            ->assertJsonCount(self::RECORDS);
    }

    public function test_index_resource_paginated()
    {
        $this->get(route('notes.index', ['paginated' => 'true']))
            ->assertStatus(200)
            ->assertJson([
                'current_page' => '1'
            ])
            ->assertJsonStructure(JsonStructure::get());
    }

    public function test_filter_by_keyword_with_paginated_results()
    {
        factory(Note::class)->create([
            'title' => 'A note...',
            'text' => 'A note text...'
        ]);

        $response = $this->get(route('notes.index', ['paginated' => 'true']))
            ->assertJson(['total' => self::RECORDS + 1]);

        $this->assertEquals(self::RECORDS + 1, count($response->decodeResponseJson()['data']));

        $this->get(route('notes.index',['paginated' => 'true', 'keyword' => 'note']))
            ->assertJson(['total' => 1]);
    }

    public function test_page_size()
    {
        $this->get(route('notes.index', ['paginated' => 'true', 'pageSize' => 6]))
            ->assertJsonFragment(['last_page' => 2]);
    }
}
