<?php

namespace App\Support\Popo;

use Illuminate\Pagination\LengthAwarePaginator;

class PopoTransformer
{
    /**
     * Transform each item from pagination data in the PlainOldPhpObject.
     *
     * @param LengthAwarePaginator $paginator
     * @return LengthAwarePaginator
     */
    public static function transformPagination(LengthAwarePaginator $paginator)
    {
        $items = $paginator->getCollection()->transform(function ($value) {
            return PlainOldPhpObject::transform($value);
        });

        return $paginator->setCollection($items);
    }
}
