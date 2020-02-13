<?php

namespace App\Domains\Notes\Services;

use App\Domains\Notes\Note;
use App\Support\Popo\PopoTransformer;
use App\Support\Services\ServiceInterface;

class FetchAllNotesService implements ServiceInterface
{
    /**
     * @var bool
     */
    protected $paginated = false;

    /**
     * @var int
     */
    protected $pageSize = 15;

    /**
     * @var null|string
     */
    protected $searchKeyword = null;

    /**
     * A list of additional query string parameter of paginator object.
     *
     * @var array
     */
    protected $queryStringParameters = [];

    /**
     * Define a keyword to filter notes.
     *
     * @param string $keyword
     * @return $this
     */
    public function searchKeyword(string $keyword)
    {
        $this->searchKeyword = $keyword;
        return $this;
    }

    /**
     * @param int $size
     * @return FetchAllNotesService
     */
    public function setPageSize($size = 15)
    {
        $this->pageSize = $size;
        return $this;
    }

    /**
     * @param array $queryStringParameters
     * @return FetchAllNotesService
     */
    public function setQueryStringParameters(array $queryStringParameters)
    {
        $this->queryStringParameters = $queryStringParameters;
        return $this;
    }

    /**
     * Define if fetched results will be returned as paginate or as collection.
     *
     * @param bool $paginated
     * @return FetchAllNotesService
     */
    public function isPaginated(bool $paginated = true)
    {
        $this->paginated = $paginated;
        return $this;
    }

    /**
     * Handle the service.
     *
     * @return mixed
     */
    public function handle()
    {
        $notes = new Note();

        // filter notes by keyword...
        if (! is_null($this->searchKeyword)) {
            $notes = $notes->where(function ($query) {
                $query->where('title', 'like', "%{$this->searchKeyword}%");
                $query->orWhere('text', 'like', "%{$this->searchKeyword}%");
            });
        }

        // notes order...
        $notes = $notes->latest();

        // define if notes will be returned through pagination or collection...
        if ($this->paginated) {
            $notes = PopoTransformer::transformPagination(
                $notes->paginate($this->pageSize)
                    ->appends($this->queryStringParameters)
            );
        } else {
            $notes = $notes->get();
        }

        return $notes;
    }
}
