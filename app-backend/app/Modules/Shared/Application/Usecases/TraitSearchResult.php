<?php

namespace App\Modules\Shared\Application\Usecases;

use App\Modules\Shared\Domain\Criteria\FieldCriteriaFactory;
use App\Modules\Shared\Domain\Dtos\SearchRequest;
use App\Modules\Shared\Domain\Enums\OperationTypeEnum;
use App\Modules\Shared\Domain\Enums\PaginationParamsEnum;
use App\Modules\Shared\Domain\Enums\SQLSortEnum;
use App\Modules\Shared\Infrastructure\Services\OperationTypeService;
use App\Modules\Shared\Infrastructure\Services\SearchRepositoryService;
use Illuminate\Pagination\LengthAwarePaginator;

trait TraitSearchResult
{
    protected function searchServiceResult(SearchRequest $request, ?OperationTypeEnum $operationTypeSet = null): LengthAwarePaginator
    {

        $operationTypeRequest = ! empty($request->operationType) ?
          OperationTypeService::findByValue($request->operationType) :
          null;

        $criteria = [];
        $columns = ! empty($request->columns) ? $request->columns : ['*'];
        $sortType = $request->sortType ? SQLSortEnum::from($request->sortType) : SQLSortEnum::SORT_DESC;
        $sortField = $request->sortField;
        $factoryCriteria = app(FieldCriteriaFactory::class);
        $operationType = $operationTypeSet ?: $operationTypeRequest;

        if (! $sortField) {
            $sortField = isset($this->entity) ? $this->entity->getTable().'.id' : 'id';
        }

        foreach ($request->filters as $filter) {
            [$key, $operator, $value] = $filter;
            $criteria[] = $factoryCriteria->create($key, $operator, $value, $operationType);
        }

        return $this->search(
            $criteria,
            $columns,
            $request->includes,
            $sortField,
            $sortType,
            $request->itemsPerPage,
            $request->currentPage,
        );

    }

    public function search(
        array $criteria = [],
        array $columns = ['*'],
        array $includes = [],
        string $sortField = 'id',
        SQLSortEnum $sortType = SQLSortEnum::SORT_DESC,
        int $itemsPerPage = PaginationParamsEnum::DEFAULT_ITEMS_PER_PAGE,
        int $currentPage = 1
    ): LengthAwarePaginator {

        $query = $this->entity->newQueryWithoutRelationships();

        $joins = [];
        if (isset($this->joins)) {
            $joins = $this->joins;
        }

        $query = SearchRepositoryService::applySearchParams(
            $query, $criteria, $columns, $includes,
            $sortField, $sortType, $joins
        );

        return $query->paginate(perPage: $itemsPerPage, page: $currentPage);
    }
}
