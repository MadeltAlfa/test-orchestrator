<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait SearchAndPaginate
{
    /**
     * Apply pencarian 'name' dari request('search') lalu paginate.
     */
    public function searchAndPaginate(Builder $query, string $column = 'name', int $perPage = 15): LengthAwarePaginator
    {
        $search = request('search');

        if ($search) {
            $query->where($column, 'like', "%{$search}%");
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
