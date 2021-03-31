<?php
/**
 * Clean Composable eloquent filters
 * ref.: https://medium.com/@mykeels/writing-clean-composable-eloquent-filters-edd242c82cc8
 */

namespace App\Support\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{

    protected $request;
    protected $builder;

    protected $defaultOrderBy = 'asc';
    protected $defaultSortByColumn = 'name';

    protected $sorted = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if (! method_exists($this, $name)) {
                if ($name == 'sort_by' || $name == 'order_by') {
                    if ($this->sorted) {
                        continue;
                    } else {
                        $this->sorted = true;
                        return $this->builder->orderBy($this->filters()['sort_by'], $this->filters()['order_by']);
                    }
                } else {
                    continue;
                }
            }
            if (empty($value)) {
                continue;
            }
            if (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        return $this->builder;
    }

    public function filters()
    {
        $result = [];
        $input = $this->request->all();
        if (!array_key_exists("sort_by",$input)) {
            $input['sort_by'] = $this->defaultSortByColumn;
        }
        if (!array_key_exists("order_by",$input)) {
            $input['order_by'] = $this->defaultOrderBy;
        }
        if (array_key_exists("keyword",$input)) {
            $result['keyword']  = $input['keyword'];
            $result['sort_by']  = $input['sort_by'];
            $result['order_by'] = $input['order_by'];
        } else {
            $result = $input;
        }
        return $result;
    }
}
