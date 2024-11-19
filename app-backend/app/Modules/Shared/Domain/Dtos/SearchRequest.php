<?php

namespace App\Modules\Shared\Domain\Dtos;

use Exception;

class SearchRequest
{
    public mixed $filters = null;

    public mixed $columns = null;

    public mixed $includes = null;

    public ?string $sortField = null;

    public ?string $sortType = null;

    public ?int $itemsPerPage = null;

    public ?int $currentPage = null;

    public ?string $operationType = null;

    /**
     * @throws Exception
     */
    public function __construct(array $params)
    {
        $this->filters = array_key_exists('filters', $params) ?
          $this->processArrayParam($params['filters']) : [];

        $this->columns = array_key_exists('columns', $params) ?
          $this->processArrayParam($this->columns) : [];

        $this->includes = array_key_exists('includes', $params) ?
          $this->processArrayParam($this->includes) : [];

        $this->sortField = array_key_exists('sortField', $params) ?
          $params['sortField'] : config('modules.domain_request.sort_field');

        $this->sortType = array_key_exists('sortType', $params) ?
          $params['sortType'] : config('modules.domain_request.sort_type');

        $this->itemsPerPage = array_key_exists('itemsPerPage', $params) ?
          intval($params['itemsPerPage']) : config('modules.domain_request.itemsPerPage');

        $this->currentPage = array_key_exists('currentPage', $params) ?
          intval($params['currentPage']) : config('modules.domain_request.currentPage');

        $this->operationType = array_key_exists('operationType', $params) ?
          $params['operationType'] : null;

        $max = config('modules.domain_request.maxItemsPerPage');
        if ($this->itemsPerPage > $max) {
            $this->itemsPerPage = $max;
        }
    }

    /**
     * Process param array
     *
     * @throws Exception
     */
    private function processArrayParam($param = null)
    {

        $result = [];
        if (empty($param)) {
            return $result;
        }

        if (is_string($param)) {
            $result = json_decode($param, true);

            if (is_string($result)) {
                $result = json_decode($result, true);
            }

            // Check if the decoding was successful
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error decoding JSON');
            }

        } else {
            $result = $param;
        }

        return $result;
    }
}
