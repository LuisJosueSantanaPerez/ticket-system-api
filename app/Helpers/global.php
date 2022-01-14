<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorAlias;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


/**
 * @param array $filters
 * @param string $table
 * @return LengthAwarePaginatorAlias|Collection
 */
function filtersResources(array $filters = [], string $table = "")
{
    $query = DB::table($table);

    foreach ($filters as $key => $value) {
        if ($key == "q") {
            continue;
        }
        if ($key == "sort") {
            $fields = explode(",", $value);
            foreach ($fields as $field) {
                $query->orderBy(str_replace("-", "", $field), !strpos($field, "-") ? 'desc' : 'asc');
            }
            continue;
        }
        if ($key == "fields") {
            $query->select(DB::raw($value));
            continue;
        }
        if ($key == "deleted_at") {
            $query->whereNull('deleted_at');
            continue;
        }

        if($key == "activated"){
            $query->where("activated", '=' , $value);
        }

        if ($key == "per_page")
            continue;
        if ($key == "page")
            continue;

        $query->where($key, $value);
    }

    if (isset($filters['per_page']))
        return $query->paginate($filters['per_page']);

    return $query->get();
}
