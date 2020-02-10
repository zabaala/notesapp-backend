<?php

namespace App\Support\Pagination;

class JsonStructure
{
    public static function get()
    {
        return [
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ];
    }
}
