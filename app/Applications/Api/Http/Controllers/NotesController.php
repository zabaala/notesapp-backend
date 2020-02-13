<?php

namespace App\Applications\Api\Http\Controllers;

use App\Domains\Notes\Services\CreateNoteService;
use App\Domains\Notes\Services\DeleteNoteByIdService;
use App\Domains\Notes\Services\FetchAllNotesService;
use App\Domains\Notes\Services\FindNoteByIdService;
use App\Domains\Notes\Services\UpdateNoteService;
use App\Support\Validation\ValidationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotesController extends BaseController
{
    /**
     * Fetch all notes.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $service = new FetchAllNotesService();

        if ($request->has('pageSize')) {
            $service->setPageSize($request->pageSize);
        }

        if ($request->has('keyword')) {
            $service->searchKeyword($request->keyword);
        }

        $isPaginated = $request->has('paginated') && $request->paginated === 'true';

        if ($isPaginated) {
            $service
                ->isPaginated($isPaginated)
                ->setQueryStringParameters(request()->all());
        }

        return $service->handle();
    }

    /**
     * Find a note by id.
     *
     * @param $note
     * @return mixed
     */
    public function show($note)
    {
        try {
            $note = (new FindNoteByIdService($note))->handle();
            return response($note, self::$STATUS_CODE_SUCCESS);
        } catch (ModelNotFoundException $e) {
            return $this->responseWithErrors(
                "Note '${note}' not found.",
                self::$STATUS_CODE_NOT_FOUND_ERROR
            );
        }
    }

    /**
     * Store a new note.
     *
     * @return ResponseFactory|Response
     */
    public function store()
    {
        try {
            $note = (new CreateNoteService(request()->all('title', 'text')))->handle();
            return response($note, self::$STATUS_CODE_CREATED);
        } catch (ValidationException $e) {
            return $this->responseWithErrors($e, self::$STATUS_CODE_VALIDATION_ERROR);
        }
    }

    /**
     * Update a note by id.
     *
     * @param $note
     * @return ResponseFactory|Response|mixed
     */
    public function update($note)
    {
        try {
            $data = (new UpdateNoteService($note, request()->all(['title', 'text'])))->handle();
            return response($data, self::$STATUS_CODE_UPDATED);
        } catch (ValidationException $e) {
            return $this->responseWithErrors($e, self::$STATUS_CODE_VALIDATION_ERROR);
        }
    }

    /**
     * Destroy a note by id.
     *
     * @param $note
     * @return ResponseFactory|Response
     */
    public function destroy($note)
    {
        try {
            (new DeleteNoteByIdService($note))->handle();
            return response(null, self::$STATUS_CODE_DELETED);
        } catch (ModelNotFoundException $e) {
            return $this->responseWithErrors(
                "Note ${note} not found.",
                self::$STATUS_CODE_VALIDATION_ERROR
            );
        }
    }
}
