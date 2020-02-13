<?php

namespace Tests\Unit;

use \App\Domains\Notes\Note;
use \App\Domains\Notes\Services\FetchAllNotesService;
use App\Support\Popo\PlainOldPhpObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class FetchAllNotesServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    const RECORDS = 5;

    public function setUp(): void
    {
        parent::setUp();

        factory(Note::class, self::RECORDS)->create();
        $this->service = new FetchAllNotesService();
    }

    public function test_count_records_in_database()
    {
        $notes = $this->service->handle();
        $this->assertEquals(self::RECORDS, count($notes));
        $this->assertInstanceOf(Collection::class, $notes);
    }

    public function test_pagination_results()
    {
        /** @var $notes LengthAwarePaginator $notes */
        $notes = $this->service->isPaginated()->handle();

        $this->assertInstanceOf(LengthAwarePaginator::class, $notes);
        $this->assertEquals(self::RECORDS, $notes->count());

        foreach ($notes->all() as $note ) {
            $this->assertInstanceOf(PlainOldPhpObject::class, $note);
        }
    }

    public function test_filter_by_keyword()
    {
        factory(Note::class)->create([
            'title' => 'a note',
            'text' => 'a note text'
        ]);

        $notes = $this->service->searchKeyword('note')->handle();
        $this->assertEquals(1, count($notes));
    }
}
