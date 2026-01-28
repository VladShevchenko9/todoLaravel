<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository
{
    private const LIMIT = 3;

    /** @var class-string<Model> */
    protected string $modelClass;

    public function find(int $id): ?Model
    {
        return $this->getBuilder()->find($id);
    }

    // @todo: Add other basic methods.

    public function paginateWithFilters(
        array $filters = [],
        array $optionalFilters = [],
        array $searchPartials = [],
        array $optionalSearchPartials = [],
    ): LengthAwarePaginator {
        $builder = $this->getBuilder();

        foreach ($filters as $key => $value) {
            $builder->where($key, $value);
        }

        foreach ($searchPartials as $key => $value) {
            $builder->where($key, 'like', '%'.$value.'%');
        }

        $builder->where(function (Builder $query) use ($optionalFilters, $optionalSearchPartials) {
            foreach ($optionalFilters as $key => $value) {
                $query->orWhere($key, $value);
            }

            foreach ($optionalSearchPartials as $key => $value) {
                $query->orWhere($key, 'like', '%'.$value.'%');
            }
        });

        return $builder->latest()->paginate(self::LIMIT);
    }

    private function getBuilder(): Builder
    {
        return $this->modelClass::query();
    }
}
