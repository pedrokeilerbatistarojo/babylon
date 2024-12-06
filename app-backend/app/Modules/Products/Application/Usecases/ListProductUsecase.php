<?php

namespace App\Modules\Products\Application\Usecases;

use App\Modules\Products\Domain\Models\Product;
use App\Modules\Products\Domain\Resources\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Pedrokeilerbatistarojo\Smartfilter\Services\FilterService;

readonly class ListProductUsecase
{

    public function __construct(
        private FilterService $filterService
    ) {}

    /**
     * @throws \Exception
     */
    public function execute(array $inputs): AnonymousResourceCollection
    {
        $result = $this->filterService->execute(Product::class, $inputs);

        return ProductResource::collection($result);
    }
}
